<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/util.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/backstage/apply/apply.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/layer/layer.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/jscal2.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/border-radius.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/js/calendar/win2k.css') }}"/>
    <script type="text/javascript" src="{{ URL::asset('/js/calendar/calendar.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/calendar/lang/en.js') }}"></script>

</head>
<body>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/index">首页</a></li>
        <li>提现管理</li>
    </ul>
</div>

<div class="rightinfo">
    <form id="search_form" action="{{url('Apply/index')}}" method="post">
        <ul class="seachform">
            <li><label>店员名称/手机号/汇款流水号</label><input id="keyword" name="keyword" type="text" value="<?php echo $params['keyword']; ?>" class="scinput"></li>
            <li><label>状态</label>
                <select class="mini-select" name="state">
                    <option value="-1" <?php if($params['state'] === -1): ?> selected="selected" <?php endif; ?> >全部</option>
                    <?php foreach($aplly_status as $kk => $status): ?>
                    <option value="<?php echo $kk; ?>" <?php if($params['state'] === $kk): ?> selected="selected" <?php endif; ?> ><?php echo $status; ?></option>
                    <?php endforeach; ?>
                </select>
            </li>

            <li><label>是否有效</label>
                <select class="mini-select" name="active">
                    <option value="-1" <?php if($params['active'] === -1): ?> selected="selected" <?php endif; ?> >全部</option>
                    <option value="1" <?php if($params['active'] === 1): ?> selected="selected" <?php endif; ?> >是</option>
                    <option value="0" <?php if($params['active'] === 0): ?> selected="selected" <?php endif; ?> >否</option>
                </select>
            </li>

            <li>
                <label>申请时间</label><input name="apply_start_time" id="apply_start_time" value="<?php echo $params['apply_start_time'] ?>" type="text" class="date scinput">

            <script type="text/javascript">
                Calendar.setup({
                    weekNumbers: true,
                    inputField : "apply_start_time",
                    trigger    : "apply_start_time",
                    dateFormat: "%Y-%m-%d %H:%M:%S",
                    showTime: true,
                    minuteStep: 1,
                    onSelect   : function() {this.hide();}
                });
            </script>
            </li>

            <li>
                <label>~&nbsp; </label><input name="apply_end_time" id="apply_end_time" value="<?php echo $params['apply_end_time'] ?>" type="text" class="date scinput">

                <script type="text/javascript">
                    Calendar.setup({
                        weekNumbers: true,
                        inputField : "apply_end_time",
                        trigger    : "apply_end_time",
                        dateFormat: "%Y-%m-%d %H:%M:%S",
                        showTime: true,
                        minuteStep: 1,
                        onSelect   : function() {this.hide();}
                    });
                </script>
            </li>
            <li><label>&nbsp;</label><input name="searchsubmit" type="submit" class="scbtn" value="查询"></li>
        </ul>
    </form>
    <table class="tablelist">
        <thead>
        <tr>
            {{--<th><input name="" type="checkbox" value=""/></th>--}}
            <th>ID</th>
            <th>店员名称</th>
            <th>手机</th>
            <th>身份证号</th>
            <th>金额</th>
            <th>状态</th>
            <th>是否有效</th>
            <th>申请时间</th>
            <th>帐户类型</th>
            <th>汇款流水号</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
        <tr>
            {{--<td><input name="" type="checkbox" value=""/></td>--}}
            <td class="itemid"><?=$item->id?></td>
            <td><?php echo $item->name ?></td>
            <td><?php echo $item->phone ?></td>
            <td><?php echo $item->id_number ?></td>
            <td><?php echo $item->money ?></td>
            <td><?php echo $aplly_status[$item->state] ?></td>
            <td><?php echo $item->is_active == '1' ? '是' : '否' ?></td>
            <td><?php echo $item->request_time ?></td>
            <td><?php echo $item->account_type_name ?></td>
            <td><?php echo $item->serial_number ?></td>
            <td>
                <a href="javascript:void(0);" class="tablelink itemShow">查看</a>
                @if($item->state == '0' && $item->is_active == '1')
                 | <a href="javascript:void(0);" class="tablelink itemRemittance">汇款</a>
                @endif
                @if($item->state == '0' &&  $item->is_active == '1')
                 | <a href="javascript:void(0);" class="tablelink itemcancel">取消</a>
                @endif
                @if(($item->state == '2' || $item->state == '1') && $item->is_active == '1')
                 | <a href="javascript:void(0);" class="tablelink itemdelete">删除</a>
                @endif
            </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <?php
        echo $paginator->show();
    ?>

    <div id="showApplyDialog" class="tip">
        <form class="formdialog" id="addForm" action="{{url('/Admin/add')}}" method="post">
           <ul class="admindialoginfo">
               <li>
                   <span>管理员名称</span>
                   <div class="dialog-input-label">
                       <input id="user_name" name="user_name" class="dfinput dialog-error-input"/>
                       <label id="user_name-error" class="error" for="user_name"></label>
                   </div>
               </li>
               <li>
                   <span>密码</span>
                   <div class="dialog-input-label">
                       <input id="password" name="password" type="password" class="dfinput dialog-error-input"/>
                       <label id="password-error" class="error" for="password"></label>
                   </div>
               </li>
               <li>
                   <span>确认密码</span>
                   <div class="dialog-input-label">
                       <input name="confirmpwd" type="password" class="dfinput dialog-error-input"/>
                       <label id="confirmpwd-error" class="error" for="confirmpwd"></label>
                   </div>
               </li>
           </ul>
        </form>
    </div>
</div>
</body>
</html>

