# 环境要求
> php 8.0

> mysql 5.6

> composer2.x

# 部署步骤
## 安装扩展
> composer install

## 执行数据迁移
> php artisan admin:publish

> php artisan admin:install

> php artisan migrate


# 本地调试
> php artisan serve

# 线上nginx配置

> location / {
    try_files $uri $uri/ /index.php?$query_string;
}
