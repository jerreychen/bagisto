# Bagisto 2.4 项目长期记忆

## 项目基本信息
- 框架：Bagisto 2.4 (Laravel 12, PHP 8.3+, Vue 3, Tailwind CSS 3, Vite 6)
- 路径：/Users/chenjilv/Codeup/bagisto-2.4
- 40 个 Webkul 包位于 packages/Webkul/

## 主题系统
- 主题配置在 config/themes.php，通过 ThemeViewFinder 实现视图覆盖
- Theme 中间件根据 Channel->theme 字段激活主题
- 新主题需要：1) 注册到 config/themes.php 2) 注册 ServiceProvider 3) 添加 PSR-4 自动加载
- Vite 构建配置在各主题包的 vite.config.js 中，输出到 public/themes/shop/{theme}/build/

## 自定义主题
- TechBlue 主题（科技蓝白）：packages/Webkul/TechBlue/
- 主色：techBlue #0066FF, techCyan #00C6FF
- 继承 default 主题，仅覆盖 CSS 和配色

## 价格登录可见
- 5 个价格模板在 packages/Webkul/Shop/src/Resources/views/products/prices/
- 用 @auth('customer') 包裹价格内容，未登录显示"请登录"链接
- 翻译 key: shop::app.products.prices.login-to-view
- 登录路由: shop.customer.session.index

## 重要约定
- 不修改 vendor/、node_modules/、composer.lock、storage/
- 代码风格用 vendor/bin/pint（preset: laravel）
- 21 个语言区域，翻译修改需同步所有 locale 文件
