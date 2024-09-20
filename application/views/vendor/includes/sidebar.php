<ul class="sidebar-menu">
    <!--<li class="header">MAIN NAVIGATION</li>-->
    <li class="active treeview">
        <a href="<?php echo base_url('vendor_dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>

    <li>
        <a href="#"><i class="fa fa-book"></i> <span>Documentation</span></a>
    </li>
    <li><a href="#"><i class="fa fa-book"></i> <span>Oper Requirement</span></a></li>
    <li><a href="#"><i class="fa fa-book"></i> <span>Manage Employee</span>
         <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php //echo base_url('admin_vendor_lists'); ?>"><i class="fa fa-circle-o"></i> Employee Lists</a></li>
        </ul>
    </li>
    <li><a href="#"><i class="fa fa-book"></i> <span>Manage Timesheet</span></a></li>
    <li><a href="#"><i class="fa fa-book"></i> <span>Manage Invoice</span></a></li>
    <li><a href="#"><i class="fa fa-book"></i> <span>Manage Admin User</span></a></li>
    <li><a href="<?php //echo base_url('profile'); ?>"><i class="fa fa-book"></i> <span>Update Profile</span></a></li>


</ul>