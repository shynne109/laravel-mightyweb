<?php
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use MightyWeb\Models\NavigationIcon;
use MightyWeb\Services\FileUploadService;

new class extends Component {
    use WithPagination, WithFileUploads;

    // Listing properties
    public string $search = '';
    public string $filterPosition = 'all';
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
    public $icon = null;
    public ?string $existing_icon = null;
    public string $action = '';
    public string $position = 'left';
    public int $sort_order = 1;
    public bool $is_active = true;

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'action' => 'required|string|max:500',
            'position' => 'required|in:left,right',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];

        if ($this->showCreateModal) {
            $rules['icon'] = 'required|image|max:2048';
        } elseif ($this->showEditModal) {
            $rules['icon'] = 'nullable|image|max:2048';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Icon title is required.',
            'title.max' => 'Icon title cannot exceed 255 characters.',
            'icon.required' => 'Icon image is required.',
            'icon.image' => 'The file must be an image.',
            'icon.max' => 'The image size cannot exceed 2MB.',
            'action.required' => 'Action is required.',
            'action.max' => 'Action cannot exceed 500 characters.',
            'position.required' => 'Position is required.',
            'position.in' => 'Position must be either left or right.',
            'sort_order.required' => 'Sort order is required.',
            'sort_order.integer' => 'Sort order must be a number.',
            'sort_order.min' => 'Sort order cannot be negative.',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterPosition(): void
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

    public function updatedPosition(): void
    {
        // Recalculate sort order when position changes
        $maxOrder = NavigationIcon::where('position', $this->position)->max('sort_order');
        $this->sort_order = $maxOrder ? $maxOrder + 1 : 1;
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->position = 'left';
        $maxOrder = NavigationIcon::where('position', $this->position)->max('sort_order');
        $this->sort_order = $maxOrder ? $maxOrder + 1 : 1;
        $this->showCreateModal = true;
        $this->dispatch('open-modal', name: 'showCreateModal');
    }

    public function openEditModal(int $id): void
    {
        $this->resetForm();
        $navIcon = NavigationIcon::findOrFail($id);
        
        $this->editingId = $navIcon->id;
        $this->title = $navIcon->title;
        $this->existing_icon = $navIcon->icon;
        $this->action = $navIcon->action;
        $this->position = $navIcon->position;
        $this->sort_order = $navIcon->sort_order;
        $this->is_active = $navIcon->is_active;
        
        $this->showEditModal = true;
        $this->dispatch('open-modal', name: 'showEditModal');
    }

    public function save(): void
    {
        $this->validate();

        $fileService = app(FileUploadService::class);
        $iconPath = null;

        if ($this->icon) {
            $iconPath = $fileService->uploadImage($this->icon, 'navigationicons/' . $this->position);
        }

        NavigationIcon::create([
            'title' => $this->title,
            'icon' => $iconPath,
            'action' => $this->action,
            'position' => $this->position,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Navigation icon created successfully!');
        $this->showCreateModal = false;
        $this->dispatch('close-modal', name: 'showCreateModal');
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate();

        $navIcon = NavigationIcon::findOrFail($this->editingId);
        $fileService = app(FileUploadService::class);
        $iconPath = $this->existing_icon;

        if ($this->icon) {
            if ($this->existing_icon) {
                $fileService->deleteFile($this->existing_icon);
            }
            $iconPath = $fileService->uploadImage($this->icon, 'navigationicons/' . $this->position);
        }

        $navIcon->update([
            'title' => $this->title,
            'icon' => $iconPath,
            'action' => $this->action,
            'position' => $this->position,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Navigation icon updated successfully!');
        $this->showEditModal = false;
        $this->dispatch('close-modal', name: 'showEditModal');
        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $this->confirmingDelete = true;
        $this->deleteId = $id;
        $this->dispatch('open-modal', name: 'confirmingDelete');
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $navIcon = NavigationIcon::find($this->deleteId);
            
            if ($navIcon) {
                if ($navIcon->icon) {
                    $fileService = app(FileUploadService::class);
                    $fileService->deleteFile($navIcon->icon);
                }
                $navIcon->delete();
                session()->flash('success', 'Navigation icon deleted successfully!');
            }
        }

        $this->confirmingDelete = false;
        $this->dispatch('close-modal', name: 'confirmingDelete');
        $this->deleteId = null;
    }   $this->deleteId = null;
    }

    public function toggleActive(int $id): void
    {
        $navIcon = NavigationIcon::find($id);
        
        if ($navIcon) {
            $navIcon->is_active = !$navIcon->is_active;
            $navIcon->save();
            
            $status = $navIcon->is_active ? 'activated' : 'deactivated';
            session()->flash('success', "Navigation icon {$status} successfully!");
        }
    }

    public function removeExistingIcon(): void
    {
        if ($this->existing_icon) {
            $fileService = app(FileUploadService::class);
            $fileService->deleteFile($this->existing_icon);
            $this->existing_icon = null;
        }
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingId',
            'title',
            'icon',
            'existing_icon',
            'action',
            'position',
            'sort_order',
            'is_active',
        ]);
        $this->is_active = true;
        $this->position = 'left';
        $this->sort_order = 1;
        $this->resetValidation();
    }

    public function with(): array
    {
        return [
            'icons' => NavigationIcon::query()
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('action', 'like', '%' . $this->search . '%');
                })
                ->when($this->filterPosition !== 'all', function ($query) {
                    $query->where('position', $this->filterPosition);
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
            <flux:heading size="xl">Navigation Icons</flux:heading>
            <flux:subheading>Manage left and right navigation bar icons</flux:subheading>
        </div>
        <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
            Add New Icon
        </flux:button>
    </div>

    <!-- Search and Filter Bar -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search" 
                       placeholder="Search by title or action..." 
                       icon="magnifying-glass" />
        </div>
        <div class="flex items-center gap-4">
            <flux:select wire:model.live="filterPosition" placeholder="Position">
                <flux:option value="all">All Positions</flux:option>
                <flux:option value="left">Left Icons</flux:option>
                <flux:option value="right">Right Icons</flux:option>
            </flux:select>
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
    @endif

    <!-- Icons Table -->
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
                            Icon
                        </th>
                        <th wire:click="sortBy('title')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="flex items-center space-x-1">
                                <span>Title</span>
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
                        <th wire:click="sortBy('position')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="flex items-center space-x-1">
                                <span>Position</span>
                                @if ($sortField === 'position')
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
                            Action
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
                    @forelse ($icons as $icon)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm font-medium">
                                    {{ $icon->sort_order }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($icon->icon)
                                    <img src="{{ asset('storage/' . $icon->icon) }}" 
                                         alt="{{ $icon->title }}" 
                                         class="w-10 h-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $icon->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge 
                                    size="sm" 
                                    :color="$icon->position === 'left' ? 'blue' : 'purple'"
                                    :icon="$icon->position === 'left' ? 'arrow-left' : 'arrow-right'">
                                    {{ ucfirst($icon->position) }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400 font-mono truncate max-w-xs">{{ $icon->action }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge 
                                    wire:click="toggleActive({{ $icon->id }})" 
                                    size="sm" 
                                    :color="$icon->is_active ? 'green' : 'gray'"
                                    class="cursor-pointer">
                                    {{ $icon->is_active ? 'Active' : 'Inactive' }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <flux:button icon="pencil" size="sm" variant="ghost" wire:click="openEditModal({{ $icon->id }})" />
                                    <flux:button icon="trash" size="sm" variant="ghost" color="red" wire:click="confirmDelete({{ $icon->id }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <flux:icon.bolt class="w-16 h-16 mx-auto text-zinc-400 mb-4" />
                                <flux:heading size="lg" class="mb-2">No navigation icons found</flux:heading>
                                <flux:text class="mb-6">Get started by creating a new navigation icon.</flux:text>
                                <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
                                    Add New Icon
                                </flux:button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($icons->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $icons->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="confirmingDelete" class="md:w-96">
        <form wire:submit="delete" class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Navigation Icon</flux:heading>
                <flux:subheading>
                    <p class="mt-2">Are you sure you want to delete this navigation icon? This action cannot be undone.</p>
                </flux:subheading>
            </div>

            <div class="flex gap-2 justify-end">
                <flux:button variant="ghost" type="button" flux:close>Cancel</flux:button>
                <flux:button variant="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Create Icon Modal -->
    <flux:modal name="showCreateModal" class="md:w-[600px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">Create Navigation Icon</flux:heading>
            </div>

            <flux:input 
                wire:model.defer="title" 
                label="Icon Title" 
                name="title" 
                placeholder="Enter icon title" />

            <flux:input 
                wire:model.defer="action" 
                label="Action/URL" 
                name="action" 
                placeholder="https://example.com or action name" 
                description="The URL or action to trigger when icon is clicked" />

            <x-form.file-upload 
                wire:model="icon" 
                label="Icon Image" 
                name="icon" 
                required 
                accept="image/*" 
                help="Upload an icon image (max 2MB)" />

            <div class="grid grid-cols-3 gap-4">
                <flux:select 
                    wire:model="position" 
                    label="Position" 
                    name="position">
                    <flux:option value="left">Left</flux:option>
                    <flux:option value="right">Right</flux:option>
                </flux:select>

                <flux:input 
                    wire:model.defer="sort_order" 
                    label="Sort Order" 
                    name="sort_order" 
                    type="number" 
                    min="0" />

                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               wire:model.defer="is_active" 
                               class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                <flux:button variant="ghost" type="button" flux:close>Cancel</flux:button>
                <flux:button variant="primary" type="submit">Create Icon</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit Icon Modal -->
    <flux:modal name="showEditModal" class="md:w-[600px]">
        <form wire:submit="update" class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Navigation Icon</flux:heading>
            </div>

            <flux:input 
                wire:model.defer="title" 
                label="Icon Title" 
                name="title" 
                placeholder="Enter icon title" />

            <flux:input 
                wire:model.defer="action" 
                label="Action/URL" 
                name="action" 
                placeholder="https://example.com or action name" 
                description="The URL or action to trigger when icon is clicked" />

            <x-form.file-upload 
                wire:model="icon" 
                label="Icon Image" 
                name="icon" 
                :current-file="$existing_icon" 
                accept="image/*" 
                help="Upload a new icon to replace the current one (max 2MB)"
                wire:remove="removeExistingIcon" />

            <div class="grid grid-cols-3 gap-4">
                <flux:select 
                    wire:model="position" 
                    label="Position" 
                    name="position">
                    <flux:option value="left">Left</flux:option>
                    <flux:option value="right">Right</flux:option>
                </flux:select>

                <flux:input 
                    wire:model.defer="sort_order" 
                    label="Sort Order" 
                    name="sort_order" 
                    type="number" 
                    min="0" />

                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               wire:model.defer="is_active" 
                               class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                <flux:button variant="ghost" type="button" flux:close>Cancel</flux:button>
                <flux:button variant="primary" type="submit">Update Icon</flux:button>
            </div>
        </form>
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

