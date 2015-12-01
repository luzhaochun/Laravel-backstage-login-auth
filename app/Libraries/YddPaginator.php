<?php
/**
 * Created by PhpStorm.
 * User: shenglin
 * Date: 2015/11/10
 * Time: 14:55
 */

namespace App\Libraries;

// 自定义分页类
class YddPaginator
{
    /**页码**/
    public $pageNo = 1;
    /**页大小**/
    public $pageSize = 10;
    /**共多少页**/
    public $pageCount = 0;
    /**总记录数**/
    public $totalNum = 0;
    /**偏移量,当前页起始行**/
    public $offSet = 0;
    /**每页数据（分页需要带的参数）**/
    public $pageData = array();

    /**是否有上一页**/
    public $hasPrePage = true;
    /**是否有下一页**/
    public $hasNextPage = true;

    public $pageNoList = array();

    /**
     * @param int $count 总记录数
     * @param int $size 分页大小
     * @param int $pageNo 页码
     * @param array $pageData
     */
    public function  __construct($count = 0, $size = 10, $pageNo = 1, $pageData = array())
    {
        $this->totalNum = $count;//总记录数
        $this->pageSize = $size;//每页大小
        $this->pageNo = $pageNo;//页码
        //计算总页数
        $this->pageCount = ceil($this->totalNum / $this->pageSize);
        $this->pageCount = ($this->pageCount <= 0) ? 1 : $this->pageCount;
        //检查pageNo
        $this->pageNo = $this->pageNo == 0 ? 1 : $this->pageNo;
        $this->pageNo = $this->pageNo > $this->pageCount ? $this->pageCount : $this->pageNo;
        
        //计算偏移
        $this->offset = ($this->pageNo - 1) * $this->pageSize;
        //计算是否有上一页下一页
        $this->hasPrePage = $this->pageNo == 1 ? false : true;
        $this->hasNextPage = $this->pageNo >= $this->pageCount ? false : true;

        $this->pageData = $pageData;

    }

    /**
     * 分页算法
     * @return array
     */
    private function generatePageList()
    {
        $pageList = array();
        if ($this->pageCount <= 9) {
            for ($i = 0; $i < $this->pageCount; $i++) {
                array_push($pageList, $i + 1);
            }
        } else {
            if ($this->pageNo <= 4) {
                for ($i = 0; $i < 5; $i++) {
                    array_push($pageList, $i + 1);
                }
                array_push($pageList, -1);
                array_push($pageList, $this->pageCount);
            } else if ($this->pageNo > $this->pageCount - 4) {
                array_push($pageList, 1);
                array_push($pageList, -1);
                for ($i = 5; $i > 0; $i--) {
                    array_push($pageList, $this->pageCount - $i + 1);
                }
            } else if ($this->pageNo > 4 && $this->pageNo <= $this->pageCount - 4) {
                array_push($pageList, 1);
                array_push($pageList, -1);
                array_push($pageList, $this->pageNo - 2);
                array_push($pageList, $this->pageNo - 1);
                array_push($pageList, $this->pageNo);
                array_push($pageList, $this->pageNo + 1);
                array_push($pageList, $this->pageNo + 2);
                array_push($pageList, -1);
                array_push($pageList, $this->pageCount);
            }
        }
        return $pageList;
    }

    private function baseUrl($pageNo = 1, $pageSize = 10)
    {
        $url = $_SERVER['REQUEST_URI'];
        if (preg_match('/\?/', $url)){
            $url = explode('?', $url)[0]; // 获取除参数以外的URI
        }

        if(!empty($this->pageData)){
            $param = [];
            foreach ($this->pageData as $key=>$val) {
                if($key == 'pageNo')
                    $val = $pageNo;
                if($key == 'pageSize')
                    $val = $pageSize;
                $param[] = ($key . '=' . $val);
            }
            $url .= ('?' . implode('&', $param));
        }
        return $url;
    }


    /**
     * 创建分页控件
     * @return String
     */
    public function show()
    {
        $pageList = $this->generatePageList();
        $pageString = '<div class="pagin">
                           <div class="message">
                               共<i class="blue"></i>' . (!empty($this->totalNum) ? $this->totalNum : 0) . '条记录，当前显示第 ' . (!empty($this->pageNo) ? $this->pageNo : 1) . ' 页
                           </div>';
        if (!empty($pageList)) {
            if ($this->pageCount > 1) {
                $pageString .= '<ul class="paginList">';
                if ($this->hasPrePage) {
                    $pageString .= '<li class="paginItem"><a href="' . $this->baseUrl($this->pageNo - 1, $this->pageSize) . '"><span class="pagepre"></span></a></li>';
                }

                foreach ($pageList as $k => $p) {
                    if ($this->pageNo == $p) {
                        $pageString .= '<li class="paginItem current"><a>' . $this->pageNo . '</a></li>';
                        continue;
                    }
                    if ($p == -1) {
                        $pageString .= '<li class="paginItem more"><a>...</a></li>';
                        continue;
                    }
                    $pageString .= '<li class="paginItem"><a href="' . $this->baseUrl($p, $this->pageSize) . '">' . $p . '</a></li>';
                }

                if ($this->hasNextPage) {
                    $pageString .= '<li class="paginItem"><a href="' . $this->baseUrl($this->pageNo + 1, $this->pageSize) . '"><span class="pagenxt"></span></a></li>';
                }
                $pageString .= '</ul>';
            }
        }
        $pageString .= ("</div>");
        return $pageString;
    }

    /*
     * 题库分页ajax
     * lws
     */

    public function show_ajax()
    {
        $pageList = $this->generatePageList();
        $pageString = '<div class="pagin">
                           <div class="message">
                               共<i class="blue"></i>' . (!empty($this->totalNum) ? $this->totalNum : 0) . '条记录，当前显示第 ' . (!empty($this->pageNo) ? $this->pageNo : 1) . ' 页
                           </div>';
        if (!empty($pageList)) {
            if ($this->pageCount > 1) {
                $pageString .= '<ul class="paginList">';
                if ($this->hasPrePage) {
//                    $pageString .= '<li class="paginItem" ><a  onclick="home_page($(this))" ajax_href="' . $this->baseUrl($this->pageNo - 1, $this->pageSize) . '"><span class="pagepre"></span></a></li>';
                    $pageString .= '<li class="paginItem" onclick="home_page($(this))" ajax_href="' . $this->baseUrl($this->pageNo - 1, $this->pageSize) . '"><a  href="javascript:void(0);" ><span class="pagepre"></span></a></li>';
                }

                foreach ($pageList as $k => $p) {
                    if ($this->pageNo == $p) {
                        $pageString .= '<li class="paginItem current"><a>' . $this->pageNo . '</a></li>';
                        continue;
                    }
                    if ($p == -1) {
                        $pageString .= '<li class="paginItem more"><a>...</a></li>';
                        continue;
                    }
//                    $pageString .= '<li class="paginItem"><a  onclick="home_page($(this))" ajax_href="' . $this->baseUrl($p, $this->pageSize) . '">' . $p . '</a></li>';
                    $pageString .= '<li class="paginItem" onclick="home_page($(this))" ajax_href="' . $this->baseUrl($p, $this->pageSize) . '"><a  href="javascript:void(0);">' . $p . '</a></li>';
                }

                if ($this->hasNextPage) {
                    $pageString .= '<li class="paginItem" onclick="home_page($(this))" ajax_href="' . $this->baseUrl($this->pageNo + 1, $this->pageSize) . '"><a href="javascript:void(0);"  ><span class="pagenxt"></span></a></li>';
                }
                $pageString .= '</ul>';
            }
        }
        $pageString .= ("</div>");
        return $pageString;
    }

}