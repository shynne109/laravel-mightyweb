<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\MightyWeb\Models\PushNotification;
use MightyWeb\Models\AppSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads, WithPagination;

    // Modal properties
    public bool $showSendModal = false;
    public string $title = '';
    public string $message = '';
    public string $url = '';
    public $image = null;
    public ?string $imagePreview = null;

    // Filter properties
    public string $search = '';
    public string $statusFilter = 'all';

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'url' => 'nullable|url|max:500',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function mount(): void
    {
        //
    }

    public function openSendModal(): void
    {
        $this->showSendModal = true;
        $this->reset(['title', 'message', 'url', 'image', 'imagePreview']);
        $this->resetValidation();
    }

    public function closeSendModal(): void
    {
        $this->showSendModal = false;
        $this->reset(['title', 'message', 'url', 'image', 'imagePreview']);
        $this->resetValidation();
    }

    public function sendNotification(): void
    {
        $this->validate();

        try {
            // Get OneSignal configuration
            $appIdSetting = AppSetting::where('key', 'onesignal_app_id')->first();
            $apiKeySetting = AppSetting::where('key', 'onesignal_rest_api_key')->first();

            if (!$appIdSetting || !$apiKeySetting) {
                session()->flash('error', 'OneSignal configuration not found. Please configure OneSignal settings first.');
                return;
            }

            $appId = $appIdSetting->value;
            $restApiKey = $apiKeySetting->value;

            // Handle image upload
            $imagePath = null;
            $imageUrl = null;
            if ($this->image) {
                $imagePath = $this->image->store('push-notifications', 'public');
                $imageUrl = asset('storage/' . $imagePath);
            }

            // Prepare OneSignal payload
            $payload = [
                'app_id' => $appId,
                'included_segments' => ['All'],
                'contents' => ['en' => $this->message],
                'headings' => ['en' => $this->title],
            ];

            if ($this->url) {
                $payload['url'] = $this->url;
            }

            if ($imageUrl) {
                $payload['big_picture'] = $imageUrl;
            }

            // Send to OneSignal
            $response = Http::withHeaders([
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => 'Basic ' . $restApiKey,
            ])->post('https://onesignal.com/api/v1/notifications', $payload);

            $responseData = $response->json();

            // Save to database
            $notification = PushNotification::create([
                'title' => $this->title,
                'message' => $this->message,
                'image' => $imagePath,
                'url' => $this->url,
                'onesignal_id' => $responseData['id'] ?? null,
                'response' => $responseData,
                'recipients' => $responseData['recipients'] ?? 0,
                'successful' => $responseData['recipients'] ?? 0,
                'status' => $response->successful() ? 'sent' : 'failed',
                'sent_at' => now(),
            ]);

            if ($response->successful()) {
                session()->flash('success', 'Push notification sent successfully to ' . ($responseData['recipients'] ?? 0) . ' devices!');
            } else {
                session()->flash('error', 'Failed to send push notification: ' . ($responseData['errors'][0] ?? 'Unknown error'));
            }

            $this->closeSendModal();
            $this->resetPage();

        } catch (\Exception $e) {
            session()->flash('error', 'Error sending notification: ' . $e->getMessage());
        }
    }

    public function deleteNotification($id): void
    {
        try {
            $notification = PushNotification::findOrFail($id);
            
            // Delete image if exists
            if ($notification->image) {
                Storage::disk('public')->delete($notification->image);
            }
            
            $notification->delete();
            
            session()->flash('success', 'Notification deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting notification: ' . $e->getMessage());
        }
    }

    public function with(): array
    {
        $query = PushNotification::query()
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->latest();

        return [
            'notifications' => $query->paginate(10),
        ];
    }
}; ?>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Push Notifications</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Manage and send push notifications to your mobile app users
                </p>
            </div>
            <button wire:click="openSendModal"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                <i class="ri-notification-3-line mr-2"></i>
                Send Notification
            </button>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg flex items-center">
                <i class="ri-checkbox-circle-line text-xl mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg flex items-center">
                <i class="ri-error-warning-line text-xl mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Search
                    </label>
                    <input type="text" 
                           id="search"
                           wire:model.live.debounce.300ms="search"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                           placeholder="Search by title or message...">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status
                    </label>
                    <select id="statusFilter" 
                            wire:model.live="statusFilter"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="all">All Status</option>
                        <option value="sent">Sent</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($notifications->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Notification
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Recipients
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Sent At
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($notifications as $notification)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start space-x-3">
                                            @if($notification->image)
                                                <img src="{{ asset('storage/' . $notification->image) }}" 
                                                     alt="Notification image"
                                                     class="w-12 h-12 rounded object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center flex-shrink-0">
                                                    <i class="ri-notification-3-line text-primary-600 dark:text-primary-400 text-xl"></i>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ $notification->title }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mt-1">
                                                    {{ $notification->message }}
                                                </p>
                                                @if($notification->url)
                                                    <a href="{{ $notification->url }}" 
                                                       target="_blank"
                                                       class="text-xs text-primary-600 dark:text-primary-400 hover:underline mt-1 inline-flex items-center">
                                                        <i class="ri-external-link-line mr-1"></i>
                                                        View Link
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($notification->status === 'sent') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($notification->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @endif">
                                            <span class="w-2 h-2 rounded-full mr-1.5
                                                @if($notification->status === 'sent') bg-green-500
                                                @elseif($notification->status === 'failed') bg-red-500
                                                @else bg-yellow-500
                                                @endif"></span>
                                            {{ $notification->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ number_format($notification->recipients) }}
                                        </div>
                                        @if($notification->failed > 0)
                                            <div class="text-xs text-red-600 dark:text-red-400">
                                                {{ $notification->failed }} failed
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $notification->sent_at?->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $notification->sent_at?->format('h:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="deleteNotification({{ $notification->id }})"
                                                wire:confirm="Are you sure you want to delete this notification?"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <i class="ri-delete-bin-line text-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="ri-notification-off-line text-6xl text-gray-400 dark:text-gray-600 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No notifications found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        @if($search || $statusFilter !== 'all')
                            Try adjusting your filters
                        @else
                            Get started by sending your first push notification
                        @endif
                    </p>
                    @if(!$search && $statusFilter === 'all')
                        <button wire:click="openSendModal"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                            <i class="ri-notification-3-line mr-2"></i>
                            Send Your First Notification
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Send Notification Modal -->
    @if($showSendModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-75 transition-opacity" 
                     wire:click="closeSendModal"></div>

                <!-- Center modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit.prevent="sendNotification">
                        <!-- Modal Header -->
                        <div class="bg-white dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                    <i class="ri-send-plane-line text-primary-600 dark:text-primary-400 mr-2"></i>
                                    Send Push Notification
                                </h3>
                                <button type="button" 
                                        wire:click="closeSendModal"
                                        class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                    <i class="ri-close-line text-2xl"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Body -->
                        <div class="bg-white dark:bg-gray-800 px-6 py-4 space-y-4">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="title"
                                       wire:model="title"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="Enter notification title">
                                @error('title') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Message <span class="text-red-500">*</span>
                                </label>
                                <textarea id="message" 
                                          wire:model="message"
                                          rows="4"
                                          class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white resize-none"
                                          placeholder="Enter notification message"></textarea>
                                @error('message') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- URL -->
                            <div>
                                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    URL (Optional)
                                </label>
                                <input type="url" 
                                       id="url"
                                       wire:model="url"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="https://example.com">
                                @error('url') 
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Image (Optional)
                                </label>
                                <div class="flex items-start space-x-4">
                                    @if($image)
                                        <div class="flex-shrink-0">
                                            <img src="{{ $image->temporaryUrl() }}" 
                                                 alt="Preview" 
                                                 class="w-24 h-24 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600">
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <label class="cursor-pointer px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors inline-flex items-center">
                                            <i class="ri-upload-line mr-2"></i>
                                            Choose Image
                                            <input type="file" 
                                                   wire:model="image" 
                                                   accept="image/*" 
                                                   class="hidden">
                                        </label>
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                            PNG, JPG up to 2MB
                                        </p>
                                        @error('image') 
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                        <div wire:loading wire:target="image" class="mt-2 text-sm text-primary-600 dark:text-primary-400">
                                            <i class="ri-loader-4-line animate-spin mr-1"></i>
                                            Uploading...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 flex items-center justify-end space-x-3">
                            <button type="button" 
                                    wire:click="closeSendModal"
                                    class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    wire:loading.attr="disabled"
                                    class="inline-flex justify-center items-center px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50">
                                <svg wire:loading wire:target="sendNotification" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <i wire:loading.remove wire:target="sendNotification" class="ri-send-plane-line mr-2"></i>
                                <span wire:loading.remove wire:target="sendNotification">Send Notification</span>
                                <span wire:loading wire:target="sendNotification">Sending...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
