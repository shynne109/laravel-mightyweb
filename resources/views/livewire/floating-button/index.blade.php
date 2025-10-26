<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use MightyWeb\Models\FloatingButton;
use MightyWeb\Services\FileUploadService;

new class extends Component {
    use WithPagination, WithFileUploads;

    // Table properties
    public string $search = '';
    public string $sortField = 'sort_order';
    public string $sortDirection = 'asc';
    public int $perPage = 10;

    // Modal states
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public bool $showDeleteModal = false;

    // Form properties
    public $buttonId = null;
    public $title = '';
    public $icon = null;
    public $currentIcon = null;
    public $action = '';
    public $sort_order = 1;
    public $is_active = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
    ];

    // Computed property for buttons list
    public function with(): array
    {
        return [
            'buttons' => FloatingButton::query()
                ->when($this->search, fn($q) => 
                    $q->where('title', 'like', "%{$this->search}%")
                      ->orWhere('action', 'like', "%{$this->search}%")
                )
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
        ];
    }

    // Reset pagination when search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Sort functionality
    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Open create modal
    public function openCreateModal(): void
    {
        $this->reset(['title', 'icon', 'currentIcon', 'action', 'sort_order', 'is_active']);
        
        // Auto-calculate next sort order
        $maxOrder = FloatingButton::max('sort_order');
        $this->sort_order = $maxOrder ? $maxOrder + 1 : 1;
        $this->is_active = true;
        
        $this->showCreateModal = true;
    }

    // Open edit modal
    public function openEditModal(int $id): void
    {
        $button = FloatingButton::findOrFail($id);
        
        $this->buttonId = $button->id;
        $this->title = $button->title;
        $this->action = $button->action;
        $this->sort_order = $button->sort_order;
        $this->is_active = $button->is_active;
        $this->currentIcon = $button->icon;
        $this->icon = null;
        
        $this->showEditModal = true;
    }

    // Confirm delete
    public function confirmDelete(int $id): void
    {
        $this->buttonId = $id;
        $this->showDeleteModal = true;
    }

    // Validation rules
    protected function rules(): array
    {
        $iconRule = $this->showCreateModal ? 'required|image|max:2048' : 'nullable|image|max:2048';
        
        return [
            'title' => 'required|string|max:255',
            'icon' => $iconRule,
            'action' => 'required|string|max:500',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Button title is required.',
            'title.max' => 'Button title cannot exceed 255 characters.',
            'icon.required' => 'Button icon is required.',
            'icon.image' => 'The file must be an image.',
            'icon.max' => 'The image size cannot exceed 2MB.',
            'action.required' => 'Action is required.',
            'action.max' => 'Action cannot exceed 500 characters.',
            'sort_order.required' => 'Sort order is required.',
            'sort_order.integer' => 'Sort order must be a number.',
            'sort_order.min' => 'Sort order cannot be negative.',
        ];
    }

    // Create button
    public function save(): void
    {
        $this->validate();

        $fileService = app(FileUploadService::class);
        $iconPath = $this->icon ? $fileService->uploadImage($this->icon, 'floatingbutton') : null;

        FloatingButton::create([
            'title' => $this->title,
            'icon' => $iconPath,
            'action' => $this->action,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);

        $this->showCreateModal = false;
        $this->reset(['title', 'icon', 'action', 'sort_order', 'is_active']);
        
        session()->flash('success', 'Floating button created successfully!');
        $this->dispatch('button-created');
    }

    // Update button
    public function update(): void
    {
        $this->validate();

        $button = FloatingButton::findOrFail($this->buttonId);
        $fileService = app(FileUploadService::class);

        $data = [
            'title' => $this->title,
            'action' => $this->action,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        if ($this->icon) {
            // Delete old icon if exists
            if ($button->icon) {
                $fileService->deleteFile($button->icon);
            }
            $data['icon'] = $fileService->uploadImage($this->icon, 'floatingbutton');
        }

        $button->update($data);

        $this->showEditModal = false;
        $this->reset(['buttonId', 'title', 'icon', 'currentIcon', 'action', 'sort_order', 'is_active']);
        
        session()->flash('success', 'Floating button updated successfully!');
        $this->dispatch('button-updated');
    }

    // Delete button
    public function delete(): void
    {
        $button = FloatingButton::findOrFail($this->buttonId);
        
        // Delete associated icon
        if ($button->icon) {
            $fileService = app(FileUploadService::class);
            $fileService->deleteFile($button->icon);
        }
        
        $button->delete();

        $this->showDeleteModal = false;
        $this->reset('buttonId');
        
        session()->flash('success', 'Floating button deleted successfully!');
        $this->dispatch('button-deleted');
    }

    // Toggle active status
    public function toggleActive(int $id): void
    {
        $button = FloatingButton::find($id);
        
        if ($button) {
            $button->is_active = !$button->is_active;
            $button->save();
            
            $status = $button->is_active ? 'activated' : 'deactivated';
            session()->flash('success', "Floating button {$status} successfully!");
        }
    }

    // Clear icon preview
    public function clearIcon(): void
    {
        $this->icon = null;
    }
}; ?>

<div class="p-6">
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <flux:heading size="xl">Floating Action Buttons</flux:heading>
            <flux:subheading>Manage floating action buttons in your app</flux:subheading>
        </div>
        <flux:button wire:click="openCreateModal" variant="primary" icon="plus">
            Add New Button
        </flux:button>
    </div>

    {{-- Search and Filter Bar --}}
    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by title or action..." icon="magnifying-glass" />
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

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-6">
            <flux:badge size="lg" color="green" variant="solid" icon="check-circle">
                {{ session('success') }}
            </flux:badge>
        </div>
    @endif

    {{-- Info Card --}}
    <div class="mb-6">
        <flux:callout icon="information-circle" variant="info">
            <strong>About Floating Action Buttons</strong><br>
            Floating action buttons (FABs) appear as circular icons overlaying your app content. They provide quick access to primary actions. Use them sparingly for the most important user actions.
        </flux:callout>
    </div>

    {{-- Buttons Table --}}
    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-700">
                    <tr>
                        <th wire:click="sortBy('sort_order')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-600">
                            <div class="flex items-center space-x-1">
                                <span>Order</span>
                                @if ($sortField === 'sort_order')
                                    <flux:icon.{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }} class="w-4 h-4" />
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                            Icon
                        </th>
                        <th wire:click="sortBy('title')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-600">
                            <div class="flex items-center space-x-1">
                                <span>Title</span>
                                @if ($sortField === 'title')
                                    <flux:icon.{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }} class="w-4 h-4" />
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                            Action
                        </th>
                        <th wire:click="sortBy('is_active')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-600">
                            <div class="flex items-center space-x-1">
                                <span>Status</span>
                                @if ($sortField === 'is_active')
                                    <flux:icon.{{ $sortDirection === 'asc' ? 'chevron-up' : 'chevron-down' }} class="w-4 h-4" />
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-zinc-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse ($buttons as $button)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge size="sm" color="zinc">{{ $button->sort_order }}</flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($button->icon)
                                    <flux:avatar src="{{ asset('storage/' . $button->icon) }}" alt="{{ $button->title }}" />
                                @else
                                    <flux:avatar />
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $button->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 dark:text-zinc-400 font-mono truncate max-w-xs">{{ $button->action }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <flux:badge 
                                    wire:click="toggleActive({{ $button->id }})" 
                                    size="sm" 
                                    :color="$button->is_active ? 'green' : 'gray'"
                                    class="cursor-pointer">
                                    {{ $button->is_active ? 'Active' : 'Inactive' }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <flux:button wire:click="openEditModal({{ $button->id }})" variant="ghost" size="sm" icon="pencil" />
                                    <flux:button wire:click="confirmDelete({{ $button->id }})" variant="ghost" size="sm" icon="trash" color="red" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <flux:icon.plus class="w-16 h-16 mx-auto text-zinc-400 mb-4" />
                                <flux:heading size="lg" class="mb-2">No floating buttons found</flux:heading>
                                <flux:text class="mb-6">Get started by creating a floating action button.</flux:text>
                                <flux:button wire:click="openCreateModal" variant="primary" icon="plus">
                                    Add New Button
                                </flux:button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($buttons->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-700">
                {{ $buttons->links() }}
            </div>
        @endif
    </div>

    {{-- Create Modal --}}
    <flux:modal name="create-button" wire:model="showCreateModal" variant="flyout">
        <form wire:submit="save">
            <flux:heading size="lg">Create Floating Button</flux:heading>
            <flux:subheading>Add a new floating action button to your app.</flux:subheading>

            <flux:separator />

            <div class="space-y-6">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model="title" placeholder="Enter button title" />
                    <flux:error name="title" />
                </flux:field>

                <flux:field>
                    <flux:label>Action URL</flux:label>
                    <flux:input wire:model="action" placeholder="https://example.com/action" />
                    <flux:description>The URL or deep link to open when button is tapped</flux:description>
                    <flux:error name="action" />
                </flux:field>

                <flux:field>
                    <flux:label>Icon</flux:label>
                    <input type="file" wire:model="icon" accept="image/*" class="block w-full text-sm text-gray-900 dark:text-white border border-gray-300 dark:border-zinc-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-zinc-700 focus:outline-none" />
                    <flux:description>Upload a circular icon (recommended: 96x96px PNG)</flux:description>
                    <flux:error name="icon" />
                    
                    @if ($icon)
                        <div class="mt-2">
                            <flux:avatar src="{{ $icon->temporaryUrl() }}" alt="Preview" />
                        </div>
                    @endif
                </flux:field>

                <div class="grid grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>Sort Order</flux:label>
                        <flux:input type="number" wire:model="sort_order" min="0" />
                        <flux:error name="sort_order" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:checkbox wire:model="is_active" label="Active" />
                    </flux:field>
                </div>
            </div>

            <flux:separator />

            <div class="flex justify-end gap-2">
                <flux:button type="button" wire:click="$set('showCreateModal', false)" variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Create Button</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Edit Modal --}}
    <flux:modal name="edit-button" wire:model="showEditModal" variant="flyout">
        <form wire:submit="update">
            <flux:heading size="lg">Edit Floating Button</flux:heading>
            <flux:subheading>Update button details and settings.</flux:subheading>

            <flux:separator />

            <div class="space-y-6">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model="title" placeholder="Enter button title" />
                    <flux:error name="title" />
                </flux:field>

                <flux:field>
                    <flux:label>Action URL</flux:label>
                    <flux:input wire:model="action" placeholder="https://example.com/action" />
                    <flux:description>The URL or deep link to open when button is tapped</flux:description>
                    <flux:error name="action" />
                </flux:field>

                <flux:field>
                    <flux:label>Icon</flux:label>
                    
                    @if ($currentIcon)
                        <div class="mb-2">
                            <flux:avatar src="{{ asset('storage/' . $currentIcon) }}" alt="Current Icon" />
                            <flux:text size="sm" class="mt-1">Current icon</flux:text>
                        </div>
                    @endif
                    
                    <input type="file" wire:model="icon" accept="image/*" class="block w-full text-sm text-gray-900 dark:text-white border border-gray-300 dark:border-zinc-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-zinc-700 focus:outline-none" />
                    <flux:description>Upload a new icon to replace the current one (optional)</flux:description>
                    <flux:error name="icon" />
                    
                    @if ($icon)
                        <div class="mt-2">
                            <flux:avatar src="{{ $icon->temporaryUrl() }}" alt="New Preview" />
                            <flux:text size="sm" class="mt-1">New icon preview</flux:text>
                        </div>
                    @endif
                </flux:field>

                <div class="grid grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>Sort Order</flux:label>
                        <flux:input type="number" wire:model="sort_order" min="0" />
                        <flux:error name="sort_order" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:checkbox wire:model="is_active" label="Active" />
                    </flux:field>
                </div>
            </div>

            <flux:separator />

            <div class="flex justify-end gap-2">
                <flux:button type="button" wire:click="$set('showEditModal', false)" variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">Update Button</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Delete Confirmation Modal --}}
    <flux:modal name="delete-button" wire:model="showDeleteModal">
        <flux:heading size="lg">Delete Floating Button</flux:heading>
        <flux:subheading>Are you sure you want to delete this floating button? This action cannot be undone.</flux:subheading>

        <flux:separator />

        <div class="flex justify-end gap-2">
            <flux:button wire:click="$set('showDeleteModal', false)" variant="ghost">Cancel</flux:button>
            <flux:button wire:click="delete" variant="danger">Delete Button</flux:button>
        </div>
    </flux:modal>
</div>
