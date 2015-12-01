var map = new BMap.Map("bdmap_contennt");
var circleMarks = [];
var marks = [];
var jumpMark = null;
map.centerAndZoom(new BMap.Point(118.820999145508, 31.9540996551514), 11);  // 初始化地图,设置中心点坐标和地图级别
map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
map.setCurrentCity("南京");          // 设置地图显示的城市 此项是必须设置的
map.enableScrollWheelZoom(true);

function createRedMark(point){
    return new BMap.Marker(point,{
        // 指定Marker的icon属性为Symbol
        icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
            scale: 1,//图标缩放大小
            fillColor: "red",//填充颜色
            fillOpacity: 0.8//填充透明度
        })
    });
}

function createGrayMark(point){
    return new BMap.Marker(point,{
        // 指定Marker的icon属性为Symbol
        icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
            scale: 1,//图标缩放大小
            fillColor: "gray",//填充颜色
            fillOpacity: 0.8//填充透明度
        })
    });
}

function createOrangeMark(point){
    return new BMap.Marker(point,{
        // 指定Marker的icon属性为Symbol
        icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
            scale: 1,//图标缩放大小
            fillColor: "orange",//填充颜色
            fillOpacity: 0.8//填充透明度
        })
    });
}

function createGreenMark(point){
    return new BMap.Marker(point,{
        // 指定Marker的icon属性为Symbol
        icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
            scale: 1,//图标缩放大小
            fillColor: "green",//填充颜色
            fillOpacity: 0.8//填充透明度
        })
    });
}

function createBlueMark(point){
    return new BMap.Marker(point,{
        // 指定Marker的icon属性为Symbol
        icon: new BMap.Symbol(BMap_Symbol_SHAPE_POINT, {
            scale: 1,//图标缩放大小
            fillColor: "blue",//填充颜色
            fillOpacity: 0.8//填充透明度
        })
    });
}

function removeAllMarks(){
    map.clearOverlays();
    marks = [];
    circleMarks = [];
}

function addAllMarks(){
    for (var i in marks) {
        map.addOverlay(marks[i]);
    }

    for (var i in circleMarks) {
        map.addOverlay(circleMarks[i]);
    }
}

var temp = [];

removeAllMarks();

for(var i in druglist){
    item = druglist[i];

    var point = new BMap.Point(item.lng, item.lat);
    var marker = null;

    if(item.state == '1'){
        marker = createOrangeMark(point);
        marker.setZIndex(0);
    }
    else if (item.state == '2') {
        marker = createRedMark(point);
        marker.setZIndex(1);
    }
    else if(item.state == '3'){
        marker = createGrayMark(point);
        marker.setZIndex(2);
    }else if(item.state == '4'){
        marker = createBlueMark(point);
        marker.setZIndex(3);
    }
    else if (item.state == '5') {
        marker = createGreenMark(point);
        marker.setZIndex(4);
        var circle = new BMap.Circle(point, 570, {strokeWeight: 1, strokeColor: "#0000ff", strokeOpacity:0.5, fillOpacity:"0"});
        circleMarks.push(circle);
    }
    else if(item.state == '6'){
        marker = createGreenMark(point);
        marker.setZIndex(5);
        var circle = new BMap.Circle(point, 570, {strokeWeight: 1, strokeColor: "#0000ff", strokeOpacity:0.5, fillOpacity:"0"});
        circleMarks.push(circle);
    }

    if(item != null) {
        marks[item.id] = marker;
    }
}

addAllMarks();