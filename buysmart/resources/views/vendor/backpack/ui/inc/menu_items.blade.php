{{-- This file is used for menu items by any Backpack v7 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-users" :link="backpack_url('user')" />
<x-backpack::menu-item title="Products" icon="la la-box" :link="backpack_url('product')" />
<x-backpack::menu-item title="Orders" icon="las la-box" :link="backpack_url('order')" />
<x-backpack::menu-item title="Product questions" icon="la la-question" :link="backpack_url('product-question')" />
<x-backpack::menu-item title="Reviews" icon="la la-star" :link="backpack_url('review')" />
<x-backpack::menu-item title="Pincodes" icon="las la-map-marker-alt" :link="backpack_url('pincode')" />

