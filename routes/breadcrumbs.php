<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// welcome
Breadcrumbs::for('welcome', function ($trail) {
    $trail->push('Trang chủ', route('welcome'));
});

// welcome > Search
Breadcrumbs::for('search', function ($trail) {
    $trail->parent('welcome');
    $trail->push('Tìm kiếm', route('form.search'));
});

// welcome > Page
Breadcrumbs::for('page', function ($trail, $article) {
    $trail->parent('welcome');
    $trail->push($article->title, route('page.article', $article->slug));
});

// welcome > Bài viết
Breadcrumbs::for('bai-viet', function ($trail) {
    $trail->parent('welcome');
    $trail->push('Bài viết');
});
// welcome > Sản phẩm
Breadcrumbs::for('san-pham', function ($trail) {
    $trail->parent('welcome');
    $trail->push('Sản phẩm', route('product.category'));
});
// welcome > Sản phẩm > [Tên sản phẩm]
Breadcrumbs::for('product.detail', function (BreadcrumbTrail $trail, $product) {
    if ($product->category) {
        $trail->parent('category', $product->category);
    } else {
        $trail->parent('san-pham');
    }
    $trail->push($product->seo_title ?? $product->name);
});
Breadcrumbs::for('authenlicate', function ($trail, $type) {
    $trail->parent('welcome');
    $trail->push($type === 'login' ? 'Đăng nhập' : 'Đăng ký', route("user.$type"));
});

// welcome > Category
Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
    if ($category->parent) {
        $trail->parent('category', $category->parent); // đệ quy cha
    } else {
        $trail->parent('welcome');
    }

    $trail->push($category->name, route('category', ['slug' => $category->slug]));
});

// welcome > Category > [Article]
Breadcrumbs::for('article', function ($trail, $article) {
    if ($article->category) {
        $trail->parent('category', $article->category);
    } else {
        $trail->parent('welcome');
    }
    $trail->push($article->seo_title ?? $article->name, route('article', $article->slug));
});

// welcome > Product > [Category] > [article]
Breadcrumbs::for('article_product', function ($trail, $article) {
    if ($article->category) {
        $trail->parent('category', $article->category);
    } else {
        $trail->parent('san-pham');
    }
    $trail->push($article->name, route('article.product', $article->slug));
});

// welcome > Cart
Breadcrumbs::for('cart', function ($trail) {
    $trail->parent('welcome');
    $trail->push('Giỏ hàng', route('cart.index'));
});

// welcome > Cart > Checkout
Breadcrumbs::for('checkout', function ($trail) {
    $trail->parent('cart');
    $trail->push('Thanh toán', route('cart.checkout'));
});
