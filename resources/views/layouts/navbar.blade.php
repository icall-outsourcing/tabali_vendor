@if(session()->has('caller'))
    <a href="{{url('/Search?ani=').session()->get('caller')}}" class="navbar-form btn btn-danger btn-sm" style="-webkit-border-bottom-right-radius: 20px;-webkit-border-bottom-left-radius: 20px;position: fixed;z-index: 10000;margin-top: 0; border-color: #ffffff">{{session()->get('caller')}}</a>
@endif
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{asset('img/icon.png')}}" height="40px" width="90px" style="margin-top: -9px !important;">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">{{trans('form.dashboard')}}</a></li>
            @if (Auth::user()->is('agent'))            
                <li><a href="{{ url(route('Complaint.index')) }}">{{trans('form.Complaint')}}  <span style="position: absolute;top: 32px;left: 23px;" class="label label-danger complaint"> {{\App\Complaint::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->where('status','opened')->count()}} </span></a></li>
            @elseif(Auth::user()->is('teamleader'))
                <li><a href="{{ url(route('Order.index')) }}">{{trans('form.orders')}}</a></li>                
                <li><a href="{{ url(route('Complaint.index')) }}">{{trans('form.Complaint')}}   <span style="position: absolute;top: 32px;left: 23px;" class="label label-danger complaint"> {{\App\Complaint::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->where('status','opened')->count()}} </span> </a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Team Leader <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url(route('Product.index')) }}">{{trans('form.products')}}</a></li>                                            
                        <li><a href="{{ url(route('Driver.index')) }}">{{trans('form.drivers')}}</a></li>
                        <li><a href="{{ url(route('Report.index')) }}">{{trans('form.report')}}</a></li>
                        <li><a href="{{ url(route('User.index')) }}">{{trans('form.User')}}</a></li>
                    </ul>
                </li>
            @elseif(Auth::user()->is('account'))                
                <li><a href="{{ url(route('Report.index')) }}">{{trans('form.report')}}</a></li>
            @elseif(Auth::user()->is('supervisor'))                
                <li><a href="{{ url(route('Complaint.index')) }}">{{trans('form.Complaint')}}   <span style="position: absolute;top: 32px;left: 23px;" class="label label-danger complaint"> {{\App\Complaint::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->where('status','opened')->count()}} </span> </a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Supervisor <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url(route('Product.index')) }}">{{trans('form.products')}}</a></li>                                            
                        <li><a href="{{ url(route('Driver.index')) }}">{{trans('form.drivers')}}</a></li>
                        <li><a href="{{ url(route('Report.index')) }}">{{trans('form.report')}}</a></li>
                    </ul>
                </li>
            @elseif(Auth::user()->is('branch'))
                <li><a href="{{ url(route('Order.index')) }}">{{trans('form.orders')}}</a></li>
                <li><a href="{{ url(route('Complaint.index')) }}">{{trans('form.Complaint')}}   <span style="position: absolute;top: 32px;left: 23px;" class="label label-danger complaint"> {{\App\Complaint::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->where('status','opened')->count()}} </span> </a></li>                
                <li><a href="{{ url(route('Report.index')) }}">{{trans('form.report')}}</a></li>
            @elseif(Auth::user()->is('helpdesk'))
                <li><a href="{{ url(route('Printer.index')) }}">{{trans('form.Printer')}}</a></li>                    
                <li><a href="{{ url(route('User.index')) }}">{{trans('form.User')}}</a></li>
            @elseif(Auth::user()->is('tabaliadmin'))
                <li><a href="{{ url('/Account/create') }}">{{trans('form.createaccount')}}</a></li>
                <li><a href="{{ url(route('Order.index')) }}">{{trans('form.orders')}}</a></li>
                <li><a href="{{ url(route('Complaint.index')) }}">{{trans('form.Complaint')}}  <span style="position: absolute;top: 32px;left: 23px;" class="label label-danger complaint"> {{\App\Complaint::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->where('status','opened')->count()}} </span></a></li>
                <li><a href="{{ url(route('Inquiry.index')) }}">{{trans('form.Inquiry')}}</a></li>
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Admin <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url(route('Printer.index')) }}">{{trans('form.Printer')}}</a></li>
                            <li><a href="{{ url(route('Product.index')) }}">{{trans('form.products')}}</a></li>
                            <li><a href="{{ url(route('Branch.index')) }}">{{trans('form.Branch')}}</a></li>
                            <li><a href="{{ url(route('Driver.index')) }}">{{trans('form.drivers')}}</a></li>
                            <li><a href="{{ url(route('Report.index')) }}">{{trans('form.report')}}</a></li>
                        </ul>
                </li>
            @elseif(Auth::user()->is('admin'))
                <li><a href="{{ url('/Account/create') }}">{{trans('form.createaccount')}}</a></li>
                <li><a href="{{ url(route('Order.index')) }}">{{trans('form.orders')}}</a></li>
                <li><a href="{{ url(route('Complaint.index')) }}">{{trans('form.Complaint')}}  <span style="position: absolute;top: 32px;left: 23px;" class="label label-danger complaint"> {{\App\Complaint::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->where('status','opened')->count()}} </span></a></li>
                <li><a href="{{ url(route('Inquiry.index')) }}">{{trans('form.Inquiry')}}</a></li>
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Admin <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url(route('Product.index')) }}">{{trans('form.products')}}</a></li>
                            <li><a href="{{ url(route('Gift.index')) }}">{{trans('form.Gift')}}</a></li>
                            <li><a href="{{ url(route('Voucher.index')) }}">{{trans('form.Voucher')}}</a></li>
                            <li><a href="{{ url(route('Branch.index')) }}">{{trans('form.Branch')}}</a></li>
                            <li><a href="{{ url(route('Driver.index')) }}">{{trans('form.drivers')}}</a></li>
                            <li><a href="{{ url(route('Report.index')) }}">{{trans('form.report')}}</a></li>
                            <li><a href="{{ url(route('User.index')) }}">{{trans('form.User')}}</a></li>
                            
                        </ul>
                </li>
            @else
            @endif
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::user()->is('admin|agent|tabaliadmin|teamleader'))
                <form  id="navsearchform" class="navbar-form navbar-left" method="get" action="{{ url('/Search') }}"> 
                    <div class="input-group" style="width: 150px;">
                        <input type="search" id="navsearchphone" name="search" class="form-control input" placeholder="">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                            <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                @endif

                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li style="padding-top: 8px"><button type="submit" class="navbar-form navbar-left btn btn-danger pull-right btn-block btn-sm" id="time"></button></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">@if(session()->has('lang'))  {{trans('form.'.session()->get('lang'))}}  @else Arabic @endif<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @if(session()->has('lang'))
                                @if(session()->get('lang') == 'ar') 
                                <li><a href="{{ url('lang/en') }}"><i class="fa fa-btn fa-sign-out"></i>{{trans('form.en')}}</a></li>
                                @else
                                    <li><a href="{{ url('lang/ar') }}"><i class="fa fa-btn fa-sign-out"></i>{{trans('form.ar')}}</a></li>
                                @endif
                            @else
                                <li><a href="{{ url('lang/en') }}"><i class="fa fa-btn fa-sign-out"></i>{{trans('form.en')}}</a></li>
                            @endif
                        </ul>
                    </li>


                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0)" data-toggle="modal" id="clearchangepasswordmessage" data-target="#ChangePassword"><i class="fa fa-btn fa-lock "></i>{{trans('form.changepassword')}}</a></li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>{{trans('form.logout')}}</a></li>
                        </ul>
                    </li>

                    
                @endif
            </ul>

        </div>
    </div>
</nav>
<script type="text/javascript">
    $("#navsearchform button[type=submit]").click(function(e){
        e.preventDefault();
        var form = jQuery(this).parents("form:first");
        var formAction = form.attr('action');
        var Action = formAction;
        form.attr('action',Action);
        $('#navsearchform').submit();
    });

    (function () {
        function checkTime(i) {
            return (i < 10) ? "0" + i : i;
        }
        function startTime() {
            var today = new Date(),
                y = checkTime(today.getFullYear()),
                m = checkTime(today.getMonth()+1),
                d = checkTime(today.getDate()),
                h = checkTime(today.getHours()),
                i = checkTime(today.getMinutes()),
                s = checkTime(today.getSeconds());
            document.getElementById('time').innerHTML = y +' / '+m+' / '+ d+' '+ h + ":" + i + ":" + s;
            t = setTimeout(function () {
                startTime()
            }, 500);
        }
        startTime();
    })();


    (function () {
        function startTime() {
        $('.alarm').toggleClass('btn-danger btn-success');
            t = setTimeout(function () {
                startTime()
            }, 1000);
        }
        startTime();
    })();
</script>