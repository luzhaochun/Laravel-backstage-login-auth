## 注意事项

### 1、目录权限
设置 storage 目录和 bootstrap/cache 目录写权限
```
sudo chmod -R a+w storage
sudo chmod -R a+w bootstrap/cache
```

### 2、调用 七牛云api(存储空间)
引入：
```
use Services\Qiniu;
```
调用：
```
$qiniu = new Qiniu('命名空间',true);
$token = $qiniu->getToken();
```