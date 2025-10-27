<?php
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use MightyWeb\Models\Menu;
use MightyWeb\Services\FileUploadService;

new class extends Component {
    use WithPagination, WithFileUploads;

    // Listing properties
    public string $search = '';
    public string $filterParent = 'all';
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
    public string $url = '';
    public $icon = null;
    public ?string $existing_icon = null;
    public ?int $parent_id = null;
    public int $sort_order = 1;
    public bool $is_active = true;

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'required|integer|min:1',
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
            'title.required' => 'Please enter a title for the menu item.',
            'url.required' => 'Please enter a URL for the menu item.',
            'icon.image' => 'The file must be an image.',
            'icon.max' => 'The icon must not be larger than 2MB.',
            'parent_id.exists' => 'The selected parent menu does not exist.',
            'sort_order.required' => 'Sort order is required.',
            'sort_order.min' => 'Sort order must be at least 1.',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterParent(): void
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

    public function updatedParentId(): void
    {
        // Recalculate sort order when parent changes
        $query = Menu::query();
        if ($this->parent_id) {
            $query->where('parent_id', $this->parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        $maxSortOrder = $query->max('sort_order');
        $this->sort_order = $maxSortOrder ? $maxSortOrder + 1 : 1;
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $query = Menu::whereNull('parent_id');
        $maxSortOrder = $query->max('sort_order');
        $this->sort_order = $maxSortOrder ? $maxSortOrder + 1 : 1;
        $this->showCreateModal = true;
        $this->dispatch('open-modal', name: 'showCreateModal');
    }

    public function openEditModal(int $id): void
    {
        $this->resetForm();
        $menu = Menu::findOrFail($id);
        
        $this->editingId = $menu->id;
        $this->title = $menu->title;
        $this->url = $menu->url;
        $this->existing_icon = $menu->icon;
        $this->parent_id = $menu->parent_id;
        $this->sort_order = $menu->sort_order;
        $this->is_active = $menu->is_active;
        
        $this->showEditModal = true;
        $this->dispatch('open-modal', name: 'showEditModal');
    }

    public function save(): void
    {
        $this->validate();

        $fileService = app(FileUploadService::class);
        $iconPath = null;

        if ($this->icon) {
            $iconPath = $fileService->uploadImage($this->icon, 'menu_icons');
        }

        Menu::create([
            'title' => $this->title,
            'url' => $this->url,
            'icon' => $iconPath,
            'parent_id' => $this->parent_id,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Menu item created successfully!');
        $this->showCreateModal = false;
        $this->dispatch('close-modal', name: 'showCreateModal');
        $this->resetForm();
    }

    public function update(): void
    {
        // Prevent circular parent-child relationship
        if ($this->editingId && $this->parent_id === $this->editingId) {
            session()->flash('error', 'A menu item cannot be its own parent.');
            return;
        }

        $this->validate();

        $menu = Menu::findOrFail($this->editingId);
        $fileService = app(FileUploadService::class);
        $iconPath = $this->existing_icon;

        if ($this->icon) {
            if ($this->existing_icon) {
                $fileService->deleteFile($this->existing_icon);
            }
            $iconPath = $fileService->uploadImage($this->icon, 'menu_icons');
        }

        $menu->update([
            'title' => $this->title,
            'url' => $this->url,
            'icon' => $iconPath,
            'parent_id' => $this->parent_id,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('success', 'Menu item updated successfully!');
        $this->showEditModal = false;
        $this->dispatch('close-modal', name: 'showEditModal');
        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $menu = Menu::find($id);
        
        // Check if menu has children
        if ($menu && $menu->children()->count() > 0) {
            session()->flash('error', 'Cannot delete menu item with sub-menus. Please delete sub-menus first.');
            return;
        }
        
        $this->confirmingDelete = true;
        $this->deleteId = $id;
        $this->dispatch('open-modal', name: 'confirmingDelete');
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            $menu = Menu::find($this->deleteId);
            
            if ($menu) {
                if ($menu->icon) {
                    $fileService = app(FileUploadService::class);
                    $fileService->deleteFile($menu->icon);
                }
                
                $menu->delete();
                session()->flash('success', 'Menu item deleted successfully!');
            }
        }

        $this->confirmingDelete = false;
        $this->dispatch('close-modal', name: 'confirmingDelete');
        $this->deleteId = null;
    }

    public function toggleActive(int $id): void
    {
        $menu = Menu::find($id);
        
        if ($menu) {
            $menu->is_active = !$menu->is_active;
            $menu->save();
            
            $status = $menu->is_active ? 'activated' : 'deactivated';
            session()->flash('success', "Menu item {$status} successfully!");
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
            'url',
            'icon',
            'existing_icon',
            'parent_id',
            'sort_order',
            'is_active',
        ]);
        $this->is_active = true;
        $this->sort_order = 1;
        $this->resetValidation();
    }

    public function with(): array
    {
        $query = Menu::query()->with('parent', 'children');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('url', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterParent === 'parent') {
            $query->whereNull('parent_id');
        } elseif ($this->filterParent === 'child') {
            $query->whereNotNull('parent_id');
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return [
            'menus' => $query->paginate($this->perPage),
            'parentMenus' => Menu::whereNull('parent_id')->orderBy('sort_order')->get(),
        ];
    }
}; ?>

<div class="p-6">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <flux:heading size="xl">Menu Management</flux:heading>
            <flux:subheading>Manage app navigation menu items and sub-menus</flux:subheading>
        </div>
        <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
            Add Menu Item
        </flux:button>
    </div>

    <!-- Search and Filter Bar -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search" 
                       placeholder="Search by title or URL..." 
                       icon="magnifying-glass" />
        </div>
        <div class="flex items-center gap-4">
            <flux:select wire:model.live="filterParent" placeholder="Filter">
                <flux:option value="all">All Items</flux:option>
                <flux:option value="parent">Parent Menus Only</flux:option>
                <flux:option value="child">Sub-menus Only</flux:option>
            </flux:select>
            <flux:select wire:model.live="perPage" placeholder="Per page">
                <flux:option value="5">5</flux:option>
                <flux:option value="10">10</flux:option>
                <flux:option value="25">25</flux:option>
                <flux:option value="50">50</flux:option>
            </flux:select>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session()->has('success'))
        <div class="mb-6">
            <flux:badge size="lg" color="green" variant="solid" icon="check-circle">
                {{ session('success') }}
            </flux:badge>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6">
            <flux:badge size="lg" color="red" variant="solid" icon="x-circle">
                {{ session('error') }}
            </flux:badge>
        </div>
    @endif
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-red-800 dark:text-red-200">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Menus Table -->
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Parent/Children
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
                    @forelse ($menus as $menu)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm font-medium">
                                    {{ $menu->sort_order }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($menu->icon)
                                    <img src="{{ asset('storage/' . $menu->icon) }}" 
                                         alt="{{ $menu->title }}" 
                                         class="w-10 h-10 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($menu->parent_id)
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $menu->title }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 font-mono truncate max-w-xs">{{ $menu->url }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($menu->parent)
                                    <span class="text-gray-600 dark:text-gray-400">
                                        Parent: <span class="font-medium">{{ $menu->parent->title }}</span>
                                    </span>
                                @elseif ($menu->children->count() > 0)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $menu->children->count() }} sub-menu{{ $menu->children->count() > 1 ? 's' : '' }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge 
                                    wire:click="toggleActive({{ $menu->id }})" 
                                    size="sm" 
                                    :color="$menu->is_active ? 'green' : 'gray'"
                                    class="cursor-pointer">
                                    {{ $menu->is_active ? 'Active' : 'Inactive' }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <flux:button icon="pencil" size="sm" variant="ghost" wire:click="openEditModal({{ $menu->id }})" />
                                    <flux:button icon="trash" size="sm" variant="ghost" color="red" wire:click="confirmDelete({{ $menu->id }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <flux:icon.bars-3 class="w-16 h-16 mx-auto text-zinc-400 mb-4" />
                                <flux:heading size="lg" class="mb-2">No menu items found</flux:heading>
                                <flux:text class="mb-6">Get started by creating your first menu item.</flux:text>
                                <flux:button variant="primary" wire:click="openCreateModal" icon="plus">
                                    Add Menu Item
                                </flux:button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($menus->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $menus->links() }}
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="confirmingDelete" class="md:w-96">
        <form wire:submit="delete" class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Menu Item</flux:heading>
                <flux:subheading>
                    <p class="mt-2">Are you sure you want to delete this menu item? This action cannot be undone.</p>
                </flux:subheading>
            </div>

            <div class="flex gap-2 justify-end">
                <flux:button variant="ghost" type="button" flux:close>Cancel</flux:button>
                <flux:button variant="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Create Menu Modal -->
    <flux:modal name="showCreateModal" class="md:w-[600px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">Create Menu Item</flux:heading>
            </div>

            <flux:input 
                wire:model.defer="title" 
                label="Menu Title" 
                name="title" 
                placeholder="Enter menu title" />

            <flux:input 
                wire:model.defer="url" 
                label="URL" 
                name="url" 
                placeholder="https://example.com or /page" 
                description="The destination URL for this menu item" />

            <x-form.file-upload 
                wire:model="icon" 
                label="Menu Icon (Optional)" 
                name="icon" 
                accept="image/*" 
                help="Upload an icon for the menu item (max 2MB)" />

            <flux:select 
                wire:model="parent_id" 
                label="Parent Menu" 
                name="parent_id" 
                variant="listbox">
                <flux:option value="">None (Top Level)</flux:option>
                @foreach($parentMenus as $parent)
                    <flux:option value="{{ $parent->id }}">{{ $parent->title }}</flux:option>
                @endforeach
            </flux:select>

            <div class="grid grid-cols-2 gap-4">
                <flux:input 
                    wire:model.defer="sort_order" 
                    label="Sort Order" 
                    name="sort_order" 
                    type="number" 
                    min="1" />

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
                <flux:button variant="primary" type="submit">Create Menu</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit Menu Modal -->
    <flux:modal name="showEditModal" class="md:w-[600px]">
        <form wire:submit="update" class="space-y-6">
            <div>
                <flux:heading size="lg">Edit Menu Item</flux:heading>
            </div>

            <flux:input 
                wire:model.defer="title" 
                label="Menu Title" 
                name="title" 
                placeholder="Enter menu title" />

            <flux:input 
                wire:model.defer="url" 
                label="URL" 
                name="url" 
                placeholder="https://example.com or /page" 
                description="The destination URL for this menu item" />

            <x-form.file-upload 
                wire:model="icon" 
                label="Menu Icon (Optional)" 
                name="icon" 
                :current-file="$existing_icon" 
                accept="image/*" 
                help="Upload a new icon to replace the current one (max 2MB)"
                wire:remove="removeExistingIcon" />

            <flux:select 
                wire:model="parent_id" 
                label="Parent Menu" 
                name="parent_id" 
                variant="listbox">
                <flux:option value="">None (Top Level)</flux:option>
                @foreach($parentMenus->where('id', '!=', $editingId) as $parent)
                    <flux:option value="{{ $parent->id }}">{{ $parent->title }}</flux:option>
                @endforeach
            </flux:select>

            <div class="grid grid-cols-2 gap-4">
                <flux:input 
                    wire:model.defer="sort_order" 
                    label="Sort Order" 
                    name="sort_order" 
                    type="number" 
                    min="1" />

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
                <flux:button variant="primary" type="submit">Update Menu</flux:button>
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

