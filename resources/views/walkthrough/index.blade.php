<?php
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use MightyWeb\Models\Walkthrough;
use MightyWeb\Services\FileUploadService;

new class extends Component {
    use WithPagination, WithFileUploads;

    // Listing properties
    public string $search = '';
    public string $sortField = 'sort_order';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Modal state
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public bool $confirmingDelete = false;

    // Form properties
    public ?int $editingId = null;
    public ?int $deleteId = null;
    public string $title = '';
    public string $description = '';
    public $image = null;
    public ?string $existing_image = null;
    public int $sort_order = 1;
    public bool $is_active = true;

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];

        if ($this->showCreateModal) {
            $rules['image'] = 'required|image|max:2048';
        } elseif ($this->showEditModal) {
            $rules['image'] = 'nullable|image|max:2048';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Walkthrough title is required.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'description.required' => 'Description is required.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'image.required' => 'Walkthrough image is required.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'The image size cannot exceed 2MB.',
            'sort_order.required' => 'Sort order is required.',
            'sort_order.integer' => 'Sort order must be a number.',
            'sort_order.min' => 'Sort order cannot be negative.',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $maxOrder = Walkthrough::max('sort_order');
        $this->sort_order = $maxOrder ? $maxOrder + 1 : 1;
        $this->showCreateModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetForm();
        $walkthrough = Walkthrough::findOrFail($id);
        
        $this->editingId = $walkthrough->id;
        $this->title = $walkthrough->title;
        $this->description = $walkthrough->description ?? '';
        $this->existing_image = $walkthrough->image;
        $this->sort_order = $walkthrough->sort_order;
        $this->is_active = $walkthrough->is_active;
        
        $this->showEditModal = true;
    }

    public function save(): void
    {
        $this->validate();

        $fileService = app(FileUploadService::class);
        $imagePath = null;

        if ($this->image) {
            $imagePath = $fileService->uploadImage($this->image, 'walkthrough');
        }

        Walkthrough::create([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Walkthrough screen created successfully!');
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate();

        $walkthrough = Walkthrough::findOrFail($this->editingId);
        $fileService = app(FileUploadService::class);
        $imagePath = $this->existing_image;

        if ($this->image) {
            if ($this->existing_image) {
                $fileService->deleteFile($this->existing_image);
            }
            $imagePath = $fileService->uploadImage($this->image, 'walkthrough');
        }

        $walkthrough->update([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $imagePath,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Walkthrough screen updated successfully!');
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $this->confirmingDelete = true;
        $this->deleteId = $id;
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $walkthrough = Walkthrough::find($this->deleteId);
            
            if ($walkthrough) {
                if ($walkthrough->image) {
                    $fileService = app(FileUploadService::class);
                    $fileService->deleteFile($walkthrough->image);
                }
                
                $walkthrough->delete();
                session()->flash('success', 'Walkthrough screen deleted successfully!');
            }
        }

        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function toggleActive(int $id): void
    {
        $walkthrough = Walkthrough::find($id);
        
        if ($walkthrough) {
            $walkthrough->is_active = !$walkthrough->is_active;
            $walkthrough->save();
            
            $status = $walkthrough->is_active ? 'activated' : 'deactivated';
            session()->flash('success', "Walkthrough screen {$status} successfully!");
        }
    }

    public function removeExistingImage(): void
    {
        if ($this->existing_image) {
            $fileService = app(FileUploadService::class);
            $fileService->deleteFile($this->existing_image);
            $this->existing_image = null;
        }
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingId',
            'title',
            'description',
            'image',
            'existing_image',
            'sort_order',
            'is_active',
        ]);
        $this->is_active = true;
        $this->sort_order = 1;
        $this->resetValidation();
    }

    public function with(): array
    {
        return [
            'walkthroughs' => Walkthrough::query()
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('description', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
        ];
    }
}; ?>

<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <flux:heading size="xl">Walkthrough Screens</flux:heading>
            <flux:subheading>Manage onboarding screens for new users</flux:subheading>
        </div>
        <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
            Add New Screen
        </flux:button>
    </div>

    <!-- Search and Filter Bar -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search" 
                       placeholder="Search by title or description..." 
                       icon="magnifying-glass" />
        </div>
        <div class="flex items-center gap-2">
            <flux:select wire:model.live="perPage" placeholder="Per page">
                <flux:option value="5">5</flux:option>
                <flux:option value="10">10</flux:option>
                <flux:option value="25">25</flux:option>
                <flux:option value="50">50</flux:option>
            </flux:select>
        </div>
    </div>

    <!-- Success Messages -->
    @if (session()->has('success'))
        <div class="mb-6">
            <flux:badge size="lg" color="green" variant="solid" icon="check-circle">
                {{ session('success') }}
            </flux:badge>
        </div>
    @endif>

    <!-- Walkthroughs Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th wire:click="sortBy('sort_order')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="flex items-center space-x-1">
                                <span>Order</span>
                                @if ($sortField === 'sort_order')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Image
                        </th>
                        <th wire:click="sortBy('title')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="flex items-center space-x-1">
                                <span>Title & Description</span>
                                @if ($sortField === 'title')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('is_active')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="flex items-center space-x-1">
                                <span>Status</span>
                                @if ($sortField === 'is_active')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if ($sortDirection === 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($walkthroughs as $walkthrough)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm font-medium">
                                    {{ $walkthrough->sort_order }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($walkthrough->image)
                                    <img src="{{ asset('storage/' . $walkthrough->image) }}" 
                                         alt="{{ $walkthrough->title }}" 
                                         class="w-16 h-16 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $walkthrough->title }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">{{ $walkthrough->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge 
                                    wire:click="toggleActive({{ $walkthrough->id }})" 
                                    size="sm" 
                                    :color="$walkthrough->is_active ? 'green' : 'gray'"
                                    class="cursor-pointer">
                                    {{ $walkthrough->is_active ? 'Active' : 'Inactive' }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <flux:button icon="pencil" size="sm" variant="ghost" wire:click="openEditModal({{ $walkthrough->id }})" />
                                    <flux:button icon="trash" size="sm" variant="ghost" color="red" wire:click="confirmDelete({{ $walkthrough->id }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <flux:icon.book-open class="w-16 h-16 mx-auto text-zinc-400 mb-4" />
                                <flux:heading size="lg" class="mb-2">No walkthrough screens found</flux:heading>
                                <flux:text class="mb-6">Get started by creating your first walkthrough screen.</flux:text>
                                <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
                                    Add New Screen
                                </flux:button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($walkthroughs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $walkthroughs->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="confirmingDelete" class="space-y-6">
        <div>
            <flux:heading size="lg">Delete Walkthrough Screen</flux:heading>
            <flux:subheading>Are you sure you want to delete this walkthrough screen? This action cannot be undone.</flux:subheading>
        </div>

        <div class="flex gap-2 justify-end">
            <flux:button variant="ghost" wire:click="$set('confirmingDelete', false)">Cancel</flux:button>
            <flux:button variant="danger" wire:click="delete">Delete</flux:button>
        </div>
    </flux:modal>

    <!-- Create Walkthrough Modal -->
    <flux:modal name="showCreateModal" class="space-y-6">
        <div>
            <flux:heading size="lg">Create Walkthrough Screen</flux:heading>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">
            <flux:input wire:model.defer="title" 
                       label="Title" 
                       placeholder="Enter walkthrough title" 
                       required />

            <flux:textarea wire:model.defer="description" 
                          label="Description" 
                          rows="4"
                          placeholder="Enter walkthrough description" 
                          required />

            <flux:input type="file" 
                       wire:model="image" 
                       label="Screen Image" 
                       accept="image/*"
                       description="Upload an image for this walkthrough screen (max 2MB)"
                       required />

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model.defer="sort_order" 
                           label="Sort Order" 
                           type="number" 
                           min="0"
                           required />

                <flux:checkbox wire:model.defer="is_active" 
                              label="Active" 
                              description="Enable this screen" />
            </div>
        </form>

        <div class="flex gap-2 justify-end">
            <flux:button variant="ghost" wire:click="$set('showCreateModal', false)">Cancel</flux:button>
            <flux:button variant="primary" wire:click="save">Create Screen</flux:button>
        </div>
    </flux:modal>

    <!-- Edit Walkthrough Modal -->
    <flux:modal name="showEditModal" class="space-y-6">
        <div>
            <flux:heading size="lg">Edit Walkthrough Screen</flux:heading>
        </div>

        <form wire:submit.prevent="update" class="space-y-6">
            <flux:input wire:model.defer="title" 
                       label="Title" 
                       placeholder="Enter walkthrough title" 
                       required />

            <flux:textarea wire:model.defer="description" 
                          label="Description" 
                          rows="4"
                          placeholder="Enter walkthrough description" 
                          required />

            <div>
                <flux:input type="file" 
                           wire:model="image" 
                           label="Screen Image" 
                           accept="image/*"
                           description="Upload a new image to replace the current one (max 2MB)" />
                
                @if ($existing_image)
                    <div class="mt-2 flex items-center gap-2">
                        <img src="{{ asset('storage/' . $existing_image) }}" class="w-20 h-20 rounded object-cover" alt="Current image">
                        <flux:button size="sm" variant="ghost" wire:click="removeExistingImage">Remove</flux:button>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model.defer="sort_order" 
                           label="Sort Order" 
                           type="number" 
                           min="0"
                           required />

                <flux:checkbox wire:model.defer="is_active" 
                              label="Active" 
                              description="Enable this screen" />
            </div>
        </form>

        <div class="flex gap-2 justify-end">
            <flux:button variant="ghost" wire:click="$set('showEditModal', false)">Cancel</flux:button>
            <flux:button variant="primary" wire:click="update">Update Screen</flux:button>
        </div>
    </flux:modal>

    <!-- Loading Overlay -->
    <div wire:loading class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700 dark:text-gray-300">Processing...</span>
        </div>
    </div>
</div>

