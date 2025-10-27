<?php
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use MightyWeb\Models\Page;
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
    public string $url = '';
    public $icon = null;
    public ?string $existing_icon = null;
    public int $sort_order = 1;
    public bool $is_active = true;

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'url' => 'required|string|max:500',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];

        if ($this->showEditModal) {
            $rules['icon'] = 'nullable|image|max:2048';
        } else {
            $rules['icon'] = 'nullable|image|max:2048';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Page title is required.',
            'title.max' => 'Page title cannot exceed 255 characters.',
            'description.max' => 'Page description cannot exceed 500 characters.',
            'url.required' => 'Page URL is required.',
            'url.max' => 'Page URL cannot exceed 500 characters.',
            'icon.image' => 'The file must be an image.',
            'icon.max' => 'The image size cannot exceed 2MB.',
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
        $maxOrder = Page::max('sort_order');
        $this->sort_order = $maxOrder ? $maxOrder + 1 : 1;
        $this->showCreateModal = true;
        $this->dispatch('open-modal', name: 'showCreateModal');
    }

    public function openEditModal(int $id): void
    {
        $this->resetForm();
        $page = Page::findOrFail($id);
        
        $this->editingId = $page->id;
        $this->title = $page->title;
        $this->description = $page->description ?? '';
        $this->url = $page->url;
        $this->existing_icon = $page->icon;
        $this->sort_order = $page->sort_order;
        $this->is_active = $page->is_active;
        
        $this->showEditModal = true;
        $this->dispatch('open-modal', name: 'showEditModal');
    }

    public function save(): void
    {
        $this->validate();

        $fileService = app(FileUploadService::class);
        $iconPath = null;

        if ($this->icon) {
            $iconPath = $fileService->uploadImage($this->icon, 'pages');
        }

        Page::create([
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'icon' => $iconPath,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Page created successfully!');
        $this->showCreateModal = false;
        $this->dispatch('close-modal', name: 'showCreateModal');
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate();

        $page = Page::findOrFail($this->editingId);
        $fileService = app(FileUploadService::class);
        $iconPath = $this->existing_icon;

        if ($this->icon) {
            if ($this->existing_icon) {
                $fileService->deleteFile($this->existing_icon);
            }
            $iconPath = $fileService->uploadImage($this->icon, 'pages');
        }

        $page->update([
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'icon' => $iconPath,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Page updated successfully!');
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
            $page = Page::find($this->deleteId);
            
            if ($page) {
                if ($page->icon) {
                    $fileService = app(FileUploadService::class);
                    $fileService->deleteFile($page->icon);
                }
                
                $page->delete();
                session()->flash('success', 'Page deleted successfully!');
            }
        }

        $this->confirmingDelete = false;
        $this->dispatch('close-modal', name: 'confirmingDelete');
        $this->deleteId = null;
    }

    public function toggleActive(int $id): void
    {
        $page = Page::find($id);
        
        if ($page) {
            $page->is_active = !$page->is_active;
            $page->save();
            
            $status = $page->is_active ? 'activated' : 'deactivated';
            session()->flash('success', "Page {$status} successfully!");
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
            'description',
            'url',
            'icon',
            'existing_icon',
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
            'pages' => Page::query()
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('description', 'like', '%' . $this->search . '%')
                          ->orWhere('url', 'like', '%' . $this->search . '%');
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
            <h2 size="xl">Pages</h2>
            <p size="sm" class="text-gray-600 dark:text-gray-400">Manage app pages and content</p>
        </div>
        <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
            Add New Page
        </flux:button>
    </div>

    <!-- Search and Filter Bar -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <flux:input 
                wire:model.debounce.300ms="search" 
                icon="magnifying-glass"
                placeholder="Search by title, description, or URL..." />
        </div>
        <div class="flex items-center gap-2">
            <flux:select wire:model="perPage" variant="listbox">
                <flux:option value="5">5 per page</flux:option>
                <flux:option value="10">10 per page</flux:option>
                <flux:option value="25">25 per page</flux:option>
                <flux:option value="50">50 per page</flux:option>
            </flux:select>
        </div>
    </div>

    <!-- Success Messages -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Pages Table -->
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
                                <span>Title & URL</span>
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
                    @forelse ($pages as $page)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm font-medium">
                                    {{ $page->sort_order }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($page->icon)
                                    <img src="{{ asset('storage/' . $page->icon) }}" 
                                         alt="{{ $page->title }}" 
                                         class="w-10 h-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $page->title }}</div>
                                    @if ($page->description)
                                        <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1">{{ $page->description }}</div>
                                    @endif
                                    <div class="text-xs text-gray-400 dark:text-gray-500 font-mono mt-1">{{ $page->url }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge 
                                    wire:click="toggleActive({{ $page->id }})" 
                                    size="sm" 
                                    :color="$page->is_active ? 'green' : 'gray'"
                                    class="cursor-pointer">
                                    {{ $page->is_active ? 'Active' : 'Inactive' }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <flux:button icon="pencil" size="sm" variant="ghost" wire:click="openEditModal({{ $page->id }})" />
                                    <flux:button icon="trash" size="sm" variant="ghost" color="red" wire:click="confirmDelete({{ $page->id }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <flux:icon.document class="w-16 h-16 mx-auto text-zinc-400 mb-4" />
                                <flux:heading size="lg" class="mb-2">No pages found</flux:heading>
                                <flux:text class="mb-6">Get started by creating your first page.</flux:text>
                                <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
                                    Add New Page
                                </flux:button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($pages->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $pages->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="confirmingDelete" class="md:w-96">
        <form wire:submit="delete" class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Page</flux:heading>
                <flux:subheading>
                    <p class="mt-2">Are you sure you want to delete this page? This action cannot be undone.</p>
                </flux:subheading>
            </div>

            <div class="flex gap-2 justify-end">
                <flux:button variant="ghost" type="button" flux:close>Cancel</flux:button>
                <flux:button variant="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Create Page Modal -->
    <flux:modal name="showCreateModal" class="md:w-[600px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">Create Page</flux:heading>
            </div>

            <flux:input 
                wire:model.defer="title" 
                label="Page Title" 
                name="title" 
                placeholder="Enter page title" />

            <x-form.textarea 
                wire:model.defer="description" 
                label="Description (Optional)" 
                name="description" 
                rows="3"
                placeholder="Enter page description" />

            <flux:input 
                wire:model.defer="url" 
                label="URL" 
                name="url" 
                placeholder="https://example.com or /page" 
                description="The destination URL for this page" />

            <x-form.file-upload 
                wire:model="icon" 
                label="Page Icon (Optional)" 
                name="icon" 
                accept="image/*" 
                help="Upload an icon for the page (max 2MB)" />

            <div class="grid grid-cols-2 gap-4">
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
                <flux:button variant="primary" type="submit">Create Page</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit Page Modal -->
    <flux:modal name="showEditModal" class="md:w-[600px]">
        <form wire:submit="update" class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Page</flux:heading>
            </div>

            <flux:input 
                wire:model.defer="title" 
                label="Page Title" 
                name="title" 
                placeholder="Enter page title" />

            <x-form.textarea 
                wire:model.defer="description" 
                label="Description (Optional)" 
                name="description" 
                rows="3"
                placeholder="Enter page description" />

            <flux:input 
                wire:model.defer="url" 
                label="URL" 
                name="url" 
                placeholder="https://example.com or /page" 
                description="The destination URL for this page" />

            <x-form.file-upload 
                wire:model="icon" 
                label="Page Icon (Optional)" 
                name="icon" 
                :current-file="$existing_icon" 
                accept="image/*" 
                help="Upload a new icon to replace the current one (max 2MB)"
                wire:remove="removeExistingIcon" />

            <div class="grid grid-cols-2 gap-4">
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
                <flux:button variant="primary" type="submit">Update Page</flux:button>
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

