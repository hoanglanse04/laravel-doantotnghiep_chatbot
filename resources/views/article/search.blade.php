@extends('layouts.master')
@section('title', 'Tìm kiếm')

@section('head')
@endsection

@section('main')
    <main>
        <!-- Breadcrumb -->
        {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('search') }}

        <section class="max-w-7xl mx-auto px-4 lg:my-10 my-4">
            <form action="{{ route('form.search') }}" method="GET">
                <h2 class="text-xl font-medium text-bmkblue-500 mb-2">Từ khóa tìm kiếm</h2>
                <input type="text" placeholder="Từ khóa" name="keywords" value="{{ request()->get('keywords') }}" class="border-2 border-gray-200 border-solid rounded-md w-full max-w-lg py-3 px-4">
            </form>

            @if (isset($products) && count($products) > 0)
                @if (request()->get('keywords') != '')
                    <h2 class="text-xl font-medium text-bmkblue-500 mb-2 mt-6">Kết quả tìm kiếm</h2>
                    @else
                    <h2 class="text-xl font-medium text-bmkblue-500 mb-2 mt-6">Có thể bạn quan tâm</h2>
                @endif
                    <div class="grid grid-cols-12 gap-6 my-6">
                        @forelse($products as $product)
                            <x-product :item="$product" colSpan="lg:col-span-2 col-span-6" />
                        @empty
                            <div class="px-4 w-full text-center text-gray-500 py-8">
                                Không có sản phẩm nào để hiển thị.
                            </div>
                        @endforelse
                    </div>
                    {{ $products->links() }}
                @elseif(isset($products) && count($products) < 1)
                <div class="text-lg my-6"> không có kết quả nào phù hợp </div>
            @endif
        </section>
    </main>
@endsection

@section('footer')

@endsection
