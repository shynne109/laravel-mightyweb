<?php

namespace MightyWeb\Http\Livewire;

use Livewire\Component;

/**
 * Dashboard Component
 * 
 * Unified dashboard providing access to all 8 MightyWeb modules in a tabbed interface.
 * 
 * @package MightyWeb
 * @version 1.1.0
 */
class Dashboard extends Component
{
    /**
     * The currently active tab.
     */
    public string $activeTab = 'app-config';

    /**
     * Switch to a different tab.
     *
     * @param string $tab The tab identifier to switch to
     * @return void
     */
    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('mightyweb::livewire.dashboard');
    }
}
