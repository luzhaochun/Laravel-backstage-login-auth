
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/admin/admin.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>

    <ul class="forminfo uew-select" style="margin-top: 10px;">
        <li>
            <span>店员名称</span>
            <div class="show_text">{{$info->name}}</div>
        </li>
        <li>
            <span>所属药店</span>
            <div class="show_text">{{$info->drugstore_name}}</div>
        </li>
        <li>
            <span>手机</span>
            <div class="show_text">{{$info->phone}}</div>
        </li>
        <li>
            <span>身份证号</span>
            <div class="show_text">{{$info->id_number}}</div>
        </li>
        <li>
            <span>金额</span>
            <div class="show_text">{{$info->money}}</div>
        </li>
        <li>
            <span>状态</span>
            <div class="show_text">{{$aplly_status[$info->state]}}</div>
        </li>
        <li>
            <span>申请时间</span>
            <div class="show_text">{{$info->request_time}}</div>
        </li>
        <li>
            <span>帐户类型</span>
            <div class="show_text">{{$info->account_type_name}}</div>
        </li>
        <li>
            <span>帐户名</span>
            <div class="show_text">{{$info->account_name}}</div>
        </li>
        <li>
            <span>帐户号</span>
            <div class="show_text">{{$info->account_number}}</div>
        </li>
        <li>
            <span>开户行</span>
            <div class="show_text">{{$info->other_info}}</div>
        </li>
        <li>
            <span>汇款流水号</span>
            <span>{{$info->serial_number}}</span>
        </li>
        <li>
            <span>完成时间</span>
            <div class="show_text">{{$info->done_time}}</div>
        </li>



    </ul>