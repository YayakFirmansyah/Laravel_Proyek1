@extends('rental')

@section('content')
<main class="bg_gray">
    <div class="container margin_30">
    <div class="page_header">
        <div class="breadcrumbs">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Category</a></li>
                <li>Page active</li>
            </ul>
        </div>
        <h1>Cart page</h1>
    </div>
    <!-- /page_header -->
    <table class="table table-striped cart-list">
                        <thead>
                            <tr>
                                <th>
                                    Product
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Quantity
                                </th>
                                <th>
                                    Subtotal
                                </th>
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="thumb_cart">
                                        <img src="{{asset ('assets/userNew/img/products/product_placeholder_square_small.jpg')}}" data-src="assets/userNew/img/products/shoes/2.jpg" class="lazy" alt="Image">
                                    </div>
                                    <span class="item_cart">Armor Okwahn II</span>
                                </td>
                                <td>
                                    <strong>$110.00</strong>
                                </td>
                                <td>
                                    <div class="numbers-row">
                                        <input type="text" value="1" id="quantity_2" class="qty2" name="quantity_2">
                                    <div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
                                </td>
                                <td>
                                    <strong>$110.00</strong>
                                </td>
                                <td class="options">
                                    <a href="#"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="thumb_cart">
                                        <img src="{{asset ('assets/userNew/img/products/product_placeholder_square_small.jpg')}}" data-src="assets/userNew/img/products/shoes/3.jpg" class="lazy" alt="Image">
                                    </div>
                                    <span class="item_cart">Armor Air Wildwood ACG</span>
                                </td>
                                <td>
                                    <strong>$90.00</strong>
                                </td>
                                
                                <td>
                                    <div class="numbers-row">
                                        <input type="text" value="1" id="quantity_3" class="qty2" name="quantity_3">
                                    <div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
                                </td>
                                <td>
                                    <strong>$90.00</strong>
                                </td>
                                <td class="options">
                                    <a href="#"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- <div class="row add_top_30 flex-sm-row-reverse cart_actions">
                        <div class="col-sm-4 text-end">
                            <button type="button" class="btn_1 gray">Update Cart</button>
                        </div>
                            <div class="col-sm-8">
                            <div class="apply-coupon">
                                <div class="form-group">
                                    <div class="row g-2">
                                        <div class="col-md-6"><input type="text" name="coupon-code" value="" placeholder="Promo code" class="form-control"></div>
                                        <div class="col-md-4"><button type="button" class="btn_1 outline">Apply Coupon</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                <!-- /cart_actions -->

    </div>
    <!-- /container -->
    
    <div class="box_cart">
        <div class="container">
        <div class="row justify-content-end">
            <div class="col-xl-4 col-lg-4 col-md-6">
        <ul>
            <li>
                <span>Subtotal</span> $240.00
            </li>
            <li>
                <span>Shipping</span> $7.00
            </li>
            <li>
                <span>Total</span> $247.00
            </li>
        </ul>
        <a href="{{url('checkoutRental')}}" class="btn_1 full-width cart">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /box_cart -->
    
</main>
@endsection

@push('css')
    <link href="{{asset ('assets/userNew/css/cart.css')}}" rel="stylesheet">
@endpush

@push('js')
<script>
    var userId;
    $.ajax({
        url: '/get-user-id',
        method: 'GET',
        success: function(response) {
            userId = response.user_id;
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
                
    $.ajax({
        url: '/cartData',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var totalHarga = 0;
            var totalBarang = 0;
            $.each(response, function(index, item) {

                var subTotal = (parseInt(item.barang.harga)*parseInt(item.jumlah));
                var html = '<tr>';
                    html += '<td>';
                        html += '<div class="thumb_cart">';
                            html += '<img src="storage/' + item.barang.foto + '" data-src="storage/' + item.barang.foto + '" class="lazy" alt="' + item.barang.nama + '">';
                        html += '</div>';
                        html += '<span class="item_cart">' + item.barang.nama + '</span>';
                    html += '</td>';
                    html += '<td>';
                        html += '<strong>Rp.' + item.barang.harga + '</strong>';
                    html += '</td>';
                    html += '<td>';
                        html += '<div class="numbers-row">';
                            html += '<input type="text" value="' + item.jumlah + '" id="quantity_1" class="qty2" name="quantity_1">';
                            html += '<div class="inc button_inc button-inc" barang-id="'+item.barang.id+'">+</div>';
                            html += '<div class="dec button_inc button-dec" barang-id="'+item.barang.id+'">-</div>';
                        html += '</div>';
                    html += '</td>';
                    html += '<td>';
                        html += '<strong class="barangSubTotal" subTotal="'+ subTotal +'">Rp.' + subTotal + '</strong>';
                    html += '</td>';
                    html += '<td class="options">';
                        html += '<a href="#"><i class="ti-trash"></i></a>';
                    html += '</td>';
                html += '</tr>';
                $(".cart-list tbody").append(html);

            });
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });

    $(document).on('click','.btn-inc', function() {
        var barangId = $(this).attr('barang-id');
        $.ajax({
            url: "/add-to-cart",
            type: "POST",
            dataType: "json",
            data: { barang_id: barangId },
            success: function(response) {
                $('.alert-success').removeClass('d-none').addClass('d-flex');
                setTimeout(() => {
                    $('.alert-success').removeClass('d-flex').addClass('d-none');
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
    
    $(document).on('click','.btn-dec', function() {
        var barangId = $(this).attr('barang-id');
        $.ajax({
            url: "/dec-item-cart",
            type: "POST",
            dataType: "json",
            data: { barang_id: barangId },
            success: function(response) {
                $('.alert-success').removeClass('d-none').addClass('d-flex');
                setTimeout(() => {
                    $('.alert-success').removeClass('d-flex').addClass('d-none');
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
</script>
@endpush