<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link href="{{ URL::asset('/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.js')}}"></script>

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZUDZKn1Ocu4lpeKE6zU7Mmgt"></script>

    <style>
        label.error {
            color: red;
            margin-top: 5px;
            margin-left: 84px;
            font-size: 12px;
        }

        .dataTables_paginate, .dataTables_filter {
            float: right;
        }
        .pagination {
            margin: 10px 0;
        }
        .pagination ul {
            margin-bottom: 0;
            margin-left: 0;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .pagination ul>li {
            display: inline;
        }
        .pagination ul>li>a, .pagination ul>li>span {
            float: left;
            padding: 4px 12px;
            line-height: 20px;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
            #border-left-width: 0;
        }
        .pagination ul>li>a:hover, .pagination ul>li>a:focus, .pagination ul>.active>a, .pagination ul>.active>span {
            background-color: #f5f5f5;
        }

        .pagination ul>li:first-child>a, .pagination ul>li:first-child>span {
            border-left-width: 1px;
            -webkit-border-bottom-left-radius: 4px;
            border-bottom-left-radius: 4px;
            -webkit-border-top-left-radius: 4px;
            border-top-left-radius: 4px;
            -moz-border-radius-bottomleft: 4px;
            -moz-border-radius-topleft: 4px;
        }

        .dataTables_paginate a {
            font-size: 13px;
            border: 1px solid #AAA;
            color: #999;
            background: #FFF;
            padding: 4px 8px;
            cursor: pointer;
            text-decoration: none !important;
        }

        div.btn {
            background: #f6f6f6;
            padding: 6px 12px 0 12px;
            height: 30px;
            line-height: 30px;
        }
        .tab-content hr{
            margin-top: 0px;
            margin-bottom: 0px;
        }
    </style>

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
    <form id="search_form" action="{{url('Map/index')}}" method="post">
        <ul class="seachform">
            <li><label>状态</label>
                <select class="medium-select" name="state">
                    <option value="-1" selected="selected">全部</option>
                    <option value="">----</option>
                    <?php foreach($drugstore_state as $key=>$cate): ?>
                    <option value="<?php echo $key; ?>"
                    <?php if($params['state'] != "" && $key == $params['state']){ echo " selected ";} ?>
                            ><?php echo $cate;?></option>
                    <?php endforeach; ?>
                </select>
            </li>

            <li><label>&nbsp;</label><input name="searchsubmit" type="submit" class="scbtn" value="查询"></li>
        </ul>
    </form>

    <div id="bdmap_contennt" class="widget-content padded clearfix" style="padding-top:0px; width: 100%;height:600px">
        <div id="mapAll"></div>
    </div>

</div>
</body>
</html>
<script>
    druglist = <?php echo $list;?>;
</script>
<script type="text/javascript" src="{{ URL::asset('/js/backstage/drugstore/map.js')}}"></script>
