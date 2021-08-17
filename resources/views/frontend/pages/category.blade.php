@extends('frontend.layouts.master')
@section('content-home')
<div class="breadcrumb-wrap">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
            <li class="breadcrumb-item active">Danh sách sản phẩm</li>
        </ul>
    </div>
</div>
<div class="product-view">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-view-top">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="amount">Sắp xếp theo</label>
                                    <div class="product-short">
                                        <div class="dropdown">
                                            <select class="dropdown-toggle" data-toggle="dropdown" name="sort" id="sort">
                                                <option value="{{Request::url()}}?sort_by=none">---Sắp xếp theo----</option>
                                                <option value="{{Request::url()}}?sort_by=asc">---Gía tăng dần----</option>
                                                <option value="{{Request::url()}}?sort_by=desc">---Gía giảm dần----</option>
                                                <option value="{{Request::url()}}?sort_by=kytu_az">---Sắp xếp từ A đến Z----</option>
                                                <option value="{{Request::url()}}?sort_by=kytu_za">---Sắp xếp từ Z đến A----</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <form>
                                    <label for="amount">Lọc giá theo: </label>
                                        <div class="product-price-range">
                                            <div id="slider-range" style="width: 100%"></div>
                                            <div class="style-range" style="float: left">
                                                <input type="text" id="amount_start" readonly style="border:0; color:#3abd20; font-weight:bold;">
                                                <input type="text" id="amount_end" readonly style="border:0; color:#3abd20; font-weight:bold;">
                                                <input type="hidden" id="start_price" name="start_price">
                                                <input type="hidden" id="end_price" name="end_price">
                                            </div>
                                            <input type="submit" class="btn" value="Lọc giá" style="float: left">
                                        </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                    </div>
                    @foreach ($all_product_category as $product)
                    <div class="col-md-4">
                        <div class="product-item">
                            <div class="product-title">
                                <a href="#">{{$product->product_name}}</a>
                                <div class="ratting">
                                @php
                                    $product_id = $product->product_id;
                                    $rating = DB::table('ratings')->where('product_id', $product_id)->avg('rating');
                                    $rating = round($rating);
                                @endphp
                                @for($count = 1; $count<=5; $count++)
                                        @php
                                            if($count<=$rating){
                                                $color = 'color: red';
                                            }else {
                                                $color = 'color: gray';
                                            }
                                        @endphp
                                    <i class="fa fa-star"  style="{{$color}}"></i>
                                @endfor
                                </div>
                            </div>
                            <div class="product-image">
                                <a href="{{route('detailproduct', $product->product_id)}}">
                                    <img src="{{$product->product_image}}" alt="{{$product->product_image}}">
                                </a>
                                <div class="product-action">
                                    <form>
                                    @csrf
                                        <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                        <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                        <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                        <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                        <input type="hidden" value="{{$product->product_number}}" class="cart_product_number_{{$product->product_id}}">
                                        <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                                        <button type="button" class="add-to-cart" name="add-to-cart" data-id_product="{{$product->product_id}}"><i class="fa fa-cart-plus"></i></button>
                                    </form>
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    <a href="{{route('detailproduct', $product->product_id)}}"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <h3>{{number_format($product->product_price)}} <span>VNĐ</span></h3>
                                <form action="{{route('addcartajax')}}" method="POST">
                                    @csrf
                                        <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}" name="cart_product_id">
                                        <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}" name="cart_product_name">
                                        <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}"  name="cart_product_image">
                                        <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}"  name="cart_product_price">
                                        <input type="hidden" value="{{$product->product_number}}" class="cart_product_number_{{$product->product_id}}"  name="cart_product_number">
                                        <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}"  name="cart_product_qty">
                                        <button type="submit" class="btn"><i class="fa fa-shopping-bag"></i>Mua ngay</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination Start -->
                <div class="col-md-12">
                    <nav aria-label="Page navigation example">
                        {{$all_product_category->links()}}
                    </nav>
                </div>
                <!-- Pagination Start -->
            </div>

            <!-- Side Bar Start -->
            @include('frontend.layouts.sidebar')
            <!-- Side Bar End -->
        </div>
    </div>
</div>

@endsection
