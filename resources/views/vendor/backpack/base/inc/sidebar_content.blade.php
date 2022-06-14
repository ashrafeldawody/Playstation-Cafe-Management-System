<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('bill') }}'><i class='nav-icon la la-question'></i> فواتير اللعب </a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('cafe-bill') }}'><i class='nav-icon la la-question'></i> Cafe bills</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('cafe-bill-item') }}'><i class='nav-icon la la-question'></i> Cafe bill items</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('device') }}'><i class='nav-icon la la-question'></i> Devices</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('inventory') }}'><i class='nav-icon la la-question'></i> Inventories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('item') }}'><i class='nav-icon la la-question'></i> Items</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('devices-category') }}'><i class='nav-icon la la-question'></i> Devices categories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('items-category') }}'><i class='nav-icon la la-question'></i> Items categories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('play-session') }}'><i class='nav-icon la la-question'></i> Play sessions</a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-globe"></i> Translations</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('language') }}"><i class="nav-icon la la-flag-checkered"></i> Languages</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('language/texts') }}"><i class="nav-icon la la-language"></i> Site texts</a></li>
    </ul>
</li>
