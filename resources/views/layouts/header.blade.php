<div class="az-header" style="border-bottom:1px solid #00beda;">
    <div class="container-fluid">
        <div class="az-header-left">
            <a href="{{url('admin')}}" class="az-logo"><span></span> <img src="{{ asset('img/logo.png') }}"
                    style="height:100px;"></a>
            <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
        </div><!-- az-header-left -->
        <div class="az-header-menu">
            <div class="az-header-menu-header">
                <a href="{{url('admin')}}" class="az-logo"><span></span> <img src="{{ asset('img/logo.png') }}"
                        style="height:100px;"></a>
                <a href="" class="close">&times;</a>
            </div><!-- az-header-menu-header -->
            <ul class="nav">
                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-chart-area-outline"></i> My
                        Profile</a>
                    <div class="az-menu-sub">
                        <nav class="nav">
                            <a href="{{ url('admin') }}" class="nav-link">Dashboard</a>
                            <a href="{{ url('my_jobs') }}" class="nav-link">My Jobs</a>
                            <?php 
                            $user_team_id = \App\User::where('id', auth()->user()->id)->first();
//                            dd($user_team_id);
                            if($user_team_id->team_id !== null){
                            ?>
                            <a href="{{ url('my_teams_jobs') }}" class="nav-link">My Team Jobs</a>
                            <?php }?>
                            <a href="{{ url('followups') }}" class="nav-link">My Follow-ups</a>
                             @if (checkPermission('accounts_issuance_list') == 1)
                            <a href="{{ url('quotation_approvals') }}" class="nav-link">Approvals & Issuance</a>
                            @endif
                        </nav>
                    </div><!-- az-menu-sub -->
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-arrow-sync"></i> Operations</a>

                    <div class="az-menu-sub">

                        <nav class="nav">
                            @if (checkPermission('inquiry/create') == 1)
                                <a href="{{ url('inquiry/create') }}" title="Create Inquiry" class="nav-link"><i
                                        style="color:green;" class="fas fa-plus-square"></i> Create Inquiry</a>
                            @endif
                            @if (checkPermission('customers') == 1)
                                <a href="{{ url('customers') }}" class="nav-link">Customers</a>
                            @endif
                            @if (checkPermission('inquiry') == 1)
                                <a href="{{ url('inquiry') }}" class="nav-link">Inquiry List</a>
                            @endif
                            <!--                            @if (checkPermission('events_manager') == 1)
<a href="{{ url('events_manager') }}" class="nav-link">Events Manager</a>
@endif-->
                            @if (checkPermission('escalations') == 1)
                                <a href="{{ url('escalations') }}" class="nav-link">Escalations</a>
                            @endif
                        </nav>
                    </div><!-- az-menu-sub -->
                </li>
                @if (checkPermission('setup') == 1)
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub"><i class="typcn typcn-power"></i> Setup</a>
                        <nav class="az-menu-sub">
                            @if (checkPermission('hotels') == 1)
                                <a href="{{ url('hotels') }}" class="nav-link">Hotels</a>
                            @endif
                            @if (checkPermission('airports') == 1)
                                <a href="{{ url('airports') }}" class="nav-link">Airports</a>
                            @endif
                            @if (checkPermission('airlines') == 1)
                                <a href="{{ url('airlines') }}" class="nav-link">Airlines</a>
                            @endif
                            @if (checkPermission('vendors') == 1)
                                <a href="{{ url('vendors') }}" class="nav-link">Vendors</a>
                            @endif
                            @if (checkPermission('packages') == 1)
                                <a href="{{ url('packages') }}" class="nav-link">Packages</a>
                            @endif
                            @if (checkPermission('campaigns') == 1)
                                <a href="{{ url('campaigns') }}" class="nav-link">Campaigns</a>
                            @endif
                            @if (checkPermission('other_services') == 1)
                                <a href="{{ url('other_services') }}" class="nav-link">Services</a>
                            @endif
                            @if (checkPermission('office_working_hours') == 1)
                                <a href="{{ url('office_working_hours') }}" class="nav-link">Office Working Hours</a>
                            @endif
                            @if (checkPermission('follow_up_types') == 1)
                                <a href="{{ url('follow_up_types') }}" class="nav-link">Follow-up Types</a>
                            @endif
                            @if (checkPermission('performance_slabs') == 1)
                                <a href="{{ url('performance_slabs') }}" class="nav-link">Performance Slabs</a>
                            @endif
                            @if (checkPermission('approval_group') == 1)
                                <a href="{{ url('approval_group') }}" class="nav-link">Approval Group</a>
                            @endif
                            @if (checkPermission('escalation_group') == 1)
                                <a href="{{ url('escalation_group') }}" class="nav-link">Escalation Group</a>
                            @endif
                            @if (checkPermission('my_bank_accounts') == 1)
                                <a href="{{ url('my_bank_accounts') }}" class="nav-link">Bank Accounts</a>
                            @endif
                            @if (checkPermission('visa_rates') == 1)
                            <a href="{{ url('visa_rate') }}" class="nav-link">Visa Rates</a>
                            @endif

                        </nav>
                    </li>
                @endif

                @if (checkPermission('administrator') == 1)
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub"><i class="typcn typcn-user"></i>Administrator</a>
                        <nav class="az-menu-sub">
                            @if (checkPermission('users') == 1)
                                <a href="{{ url('users') }}" class="nav-link">User Management</a>
                            @endif
                            @if (checkPermission('roles') == 1)
                                <a href="{{ url('roles') }}" class="nav-link">Roles Management</a>
                            @endif
                            @if (checkPermission('escalation_preferences') == 1)
                                <a href="{{ url('escalation_preferences') }}" class="nav-link">Escalation
                                    Management</a>
                            @endif
                            <a href="#" class="nav-link">Activity Management</a>
                            @if (checkPermission('departments') == 1)
                                <a href="{{ url('departments') }}" class="nav-link">Departments</a>
                            @endif
                            @if (checkPermission('activity_manager') == 1)
                                <a href="#" class="nav-link">Activity Manager</a>
                            @endif
                        </nav>
                    </li>
                @endif

                @if (checkPermission('preferences') == 1)
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub"><i
                                class="typcn typcn-tabs-outline"></i>Preferences</a>
                        <nav class="az-menu-sub">

                            @if (checkPermission('inquiry_types') == 1)
                                <a href="{{ url('inquiry_types') }}" class="nav-link">Inquiry Types</a>
                            @endif
                            @if (checkPermission('sales_references') == 1)
                                <a href="{{ url('sales_references') }}" class="nav-link">Sales References</a>
                            @endif
                            @if (checkPermission('package_types') == 1)
                                <a href="{{ url('package_types') }}" class="nav-link">Package Types</a>
                            @endif
                            @if (checkPermission('room_types') == 1)
                                <a href="{{ url('room_types') }}" class="nav-link">Room Types</a>
                            @endif


                            <a href="{{ url('/cities') }}" class="nav-link">Cities</a>
                            <a href="{{ url('/countries') }}" class="nav-link">Countries</a>
                            <a href="{{ url('addons') }}" class="nav-link">Addons</a>
                            @if (checkPermission('currency_exchange') == 1)
                            <a href="{{ url('currency_exchange') }}" class="nav-link">Rate Of Exchange</a>
                            @endif
                            <a href="{{ url('land_services') }}" class="nav-link">Land Services</a>
                            <a href="{{ url('land_services_types') }}" class="nav-link">Land Services Types </a>
                            <a href="{{ url('route') }}" class="nav-link">Route</a>
                            {{-- <a href="#" class="nav-link">Cost Center</a>
                        <a href="#" class="nav-link">General Preferences</a> --}}
                        </nav>
                    </li>
                @endif
                @if (checkPermission('accounts') == 1)
                    <li class="nav-item">
                        <a href="" class="nav-link with-sub"><i
                                class="typcn typcn-tabs-outline"></i>Accounts</a>
                        <nav class="az-menu-sub">

                            @if (checkPermission('payment_invoice_list') == 1)
                                <a href="{{ url('payment_invoice_list') }}" class="nav-link">Payments Invoice</a>
                            @endif
                            @if (checkPermission('pending_payment_list') == 1)
                                <a href="{{ url('pending_payment_list') }}" class="nav-link">Pending Payments</a>
                            @endif
                            @if (checkPermission('cheque_list') == 1)
                                <a href="{{ url('cheque_list') }}" class="nav-link">Cheque in hand</a>
                            @endif
<!--                            @if (checkPermission('roe_difference_list') == 1)
                                <a href="{{ url('roe_difference_list') }}" class="nav-link">ROE Difference</a>
                            @endif
                            @if (checkPermission('accounts_issuance_list') == 1)
                                <a href="{{ url('accounts_issuance_list') }}" class="nav-link">Issuance List</a>
                            @endif-->



                        </nav>
                    </li>
                @endif
            </ul>
        </div><!-- az-header-menu -->
        <div class="az-header-right">
            @if (checkPermission('inquiry/create') == 1)
                <a href="{{ url('inquiry/create') }}"
                    style="font-size: 14px;color:green;text-decoration:none;font-weight:bold;" title="Create Inquiry"
                    class="az-header-search-link"><i style="color:green;font-size:18px;" class="fas fa-plus-square"></i></a>
            @endif
           {{-- General Notification --}}
            <div class="dropdown az-header-notification">
                <a href="" class="" title="My General Notification" id="noti_general"><i
                        class="typcn typcn-bell"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">General Notifications</h6>
                    <p class="az-notification-text">You have <span id="noti_count_general">0</span> unread
                        notification</p>
                    <div class="az-notification-list" id="add_noti_general">
                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="">View All Notifications</a></div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->

            {{-- Approval Notification --}}
            <div class="dropdown az-header-notification">
                <a href="" class="" title="My Approvals Notification" id="noti_approvals"><i
                        class="typcn typcn-thumbs-up"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">Approvals</h6>
                    <p class="az-notification-text">You have <span id="noti_count_approvals">0</span> unread
                        notification</p>
                    <div class="az-notification-list" id="add_noti_approvals">
                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="">View All Notifications</a></div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->

            {{-- Payment Notification --}}
            <div class="dropdown az-header-notification">
                <a href="" class="" title="My Payments Notification" id="noti_payments">
                    <i class="typcn typcn-mail"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">Payments</h6>
                    <p class="az-notification-text">You have <span id="noti_count_payments">0</span> unread
                        notification</p>
                    <div class="az-notification-list" id="add_noti_payments">


                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="">View All Notifications</a></div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->

            {{-- Issuance Notification --}}
            <div class="dropdown az-header-notification">
                <a href="" class="" title="My Issuance Notification" id="noti_issuance"><i
                        class="typcn typcn-flow-merge"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">Issuance</h6>
                    <p class="az-notification-text">You have <span id="noti_count_issuance">0</span> unread
                        notification</p>
                    <div class="az-notification-list" id="add_noti_issuance">


                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="">View All Issuance</a></div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->
            <div class="dropdown az-header-notification">
                <a href="" class="" title="My Escalations Notifications" id="noti_escalations"><i
                        class="typcn typcn-warning"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">My Escalations</h6>
                    <p class="az-notification-text">You have <span id="noti_count_escalations"></span> unread
                        notification</p>
                    <div class="az-notification-list" id="add_noti_escalations">


                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="{{url('/escalation_notifications')}}">View All Escalations</a></div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->
            <div class="dropdown az-header-notification">
                <a href="" class="" title="My Team Jobs Notifications" id="noti_team"><i
                        class="typcn typcn-group"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">My Team Jobs</h6>
                    <p class="az-notification-text">You have <span id="noti_count_team"></span> unread notification
                    </p>
                    <div class="az-notification-list" id="add_noti_team">


                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="{{ url('team_notifications') }}">View All Notifications</a>
                    </div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->
            <div class="dropdown az-header-notification">
                <a href="" class="" title="My Jobs Notifications" id="noti_my_jobs"><i
                        class="typcn typcn-user"></i></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header mg-b-20 d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <h6 class="az-notification-title">My Jobs</h6>
                    <p class="az-notification-text">You have <span id="noti_count_my_jobs">0</span> unread
                        notification</p>
                    <div class="az-notification-list" id="add_noti_my_jobs">


                    </div><!-- az-notification-list -->
                    <div class="dropdown-footer"><a href="{{ url('notifications') }}">View All Notifications</a>
                    </div>
                </div><!-- dropdown-menu -->
            </div><!-- az-header-notification -->
            <!-- az-header-notification -->
            <div class="dropdown az-profile-menu">
                <a href="" class="az-img-user"><img src="{{ url('/img/default_user_2.png') }}"
                        alt="" style="height:30px;width:30px;border-radius: 50%;"></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <div class="az-header-profile">
                        <div class="az-img-user">
                            <img src="{{ url('/img/default_user_2.png') }}" alt=""
                                style="height:100px;width:100px;border-radius: 50%;">
                        </div><!-- az-img-user -->
                        <br>
                        <h6><span style="font-weight:bold">User: <?= auth()->user()->name ?> <a href="{{ url('/clear-cache') }}" title="Clear System Cache" class="" id="noti_my_jobs"><i
                                        class="typcn typcn-refresh" style="font-size:18px;color:#00beda"></i></a></span>
                                

                            </h6>
                        <span>Respect: 0</span>
                        <span>Warnings: 0</span>
                        <span></span>
                    </div><!-- az-header-profile -->

                    <a href="{{ url('my_profile') }}" class="dropdown-item"><i class="typcn typcn-user-outline"></i>
                        My Profile</a>
<!--                    <a href="#" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                    <a href="#" class="dropdown-item"><i class="typcn typcn-time"></i> My Activity</a>
                    <a href="#" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account
                        Settings</a>-->
                    <a href="{{ url('logout') }}" class="dropdown-item"><i class="typcn typcn-power-outline"></i>
                        Sign Out</a>
                </div><!-- dropdown-menu -->
            </div>
            <span style="font-weight:bold"><?= auth()->user()->name ?></span>
        </div><!-- az-header-right -->
    </div><!-- container -->
</div><!-- az-header -->
