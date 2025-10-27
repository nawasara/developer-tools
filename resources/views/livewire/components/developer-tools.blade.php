<div x-data="{ open: @entangle('isOpen') }" x-cloak>
    @if (env('APP_DEBUG'))
        <!-- Floating Button -->
        <button @click="open = true"
            class="fixed bottom-6 right-6 w-14 h-14 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 flex items-center justify-center z-50 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94
                   3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756
                   2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826
                   3.31-2.37 2.37a1.724 1.724 0 00-2.572
                   1.065c-.426 1.756-2.924 1.756-3.35
                   0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724
                   1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924
                   0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31
                   2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </button>

        <!-- Popup -->
        <div x-show="open" x-transition.opacity x-transition.scale.origin.bottom.right
            class="fixed bottom-24 right-6 w-80 bg-white dark:bg-gray-900 rounded-xl shadow-2xl z-50 border border-gray-200 dark:border-gray-700 overflow-hidden">

            <!-- Header -->
            <div
                class="bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-3 flex justify-between items-center">
                <span class="font-semibold">Developer Tools</span>
                <button @click="open = false; $wire.resetOutput();"
                    class="text-white hover:text-gray-200 rounded-full p-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-5 max-h-96 overflow-y-auto space-y-4">

                <!-- Refresh Warning -->
                @if ($needsRefresh)
                    <div
                        class="p-3 bg-yellow-100 dark:bg-yellow-800 border border-yellow-400 text-yellow-700 dark:text-yellow-200 rounded-md text-sm">
                        <p class="font-medium">⚠️ Page Refresh Required</p>
                        <p class="mt-1">Some commands require a page refresh to take effect.</p>
                        <button onclick="window.location.reload()"
                            class="mt-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs py-1 px-3 rounded transition-colors">
                            Refresh Now
                        </button>
                    </div>
                @endif

                <!-- Command Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    @php
                        $commands = [
                            ['method' => 'runMigrateFresh', 'label' => 'Migrate Fresh', 'icon' => '🔄'],
                            ['method' => 'runMigrateFreshSeed', 'label' => 'Fresh + Seed', 'icon' => '🌱'],
                            ['method' => 'runDbSeed', 'label' => 'DB Seed', 'icon' => '🗃️'],
                            ['method' => 'runVendorPublish', 'label' => 'Vendor Publish', 'icon' => '📦'],
                            ['method' => 'runClearCache', 'label' => 'Clear Cache', 'icon' => '🧹'],
                            ['method' => 'runRouteClear', 'label' => 'Clear Route', 'icon' => '🛣️'],
                            ['method' => 'runOptimize', 'label' => 'Optimize', 'icon' => '⚡'],
                            ['method' => 'runStorageLink', 'label' => 'Storage Link', 'icon' => '🔗'],
                            ['method' => 'runTinker', 'label' => 'Tinker', 'icon' => '🔗'],
                        ];
                    @endphp

                    @foreach ($commands as $cmd)
                        <button wire:click="{{ $cmd['method'] }}" wire:loading.attr="disabled"
                            class="flex items-center justify-center gap-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-xs py-2 px-3 rounded-lg hover:bg-green-600 hover:text-white transition disabled:opacity-50">
                            <span wire:loading.remove wire:target="{{ $cmd['method'] }}">{{ $cmd['icon'] }}
                                {{ $cmd['label'] }}</span>
                            <span wire:loading wire:target="{{ $cmd['method'] }}">Running...</span>
                        </button>
                    @endforeach
                </div>

                <!-- Output -->
                @if ($output)
                    <div class="border-t pt-3">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium">Output:</span>
                            <button wire:click="resetOutput"
                                class="text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300"
                                {{ $needsRefresh ? 'disabled' : '' }}>
                                Clear
                            </button>
                        </div>
                        <div
                            class="bg-gray-100 dark:bg-black/70 p-3 rounded text-xs font-mono whitespace-pre-wrap overflow-x-auto max-h-40 text-gray-800 dark:text-gray-100">
                            {{ $output }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Overlay -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 z-40" @click="open = false; $wire.resetOutput();">
        </div>
    @endif
</div>
