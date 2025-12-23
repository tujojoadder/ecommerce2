@extends('layouts.frontend.app')
@section('content')
<style>
    .product-item-opt-7{
        border: 1px solid #ccc !important;
        margin-top: 20px !important;
    }
    .custom-button{
        display: inline-block;
        font-size: 12px;
        margin-top: 10px;
        background: #7cbf42;
        color: #fff;
        border: none;
        padding: 8px;
        font-size: 10px;
        border-radius: 3px;
        float: left;
        font-weight: 600;
        width: 120px;
    }
    .custom-button2{
        display: inline-block;
        font-size: 12px;
        margin-top: 10px;
        background: #E52E04;
        color: #fff;
        border: none;
        padding: 8px;
        font-size: 10px;
        border-radius: 3px;
        float: right;
        font-weight: 600;
        width: 120px;
    }
    .custom-button2:hover{
        background: #7cbf42;
    }
    .custom-button:hover{
        background: #E52E04;
    }
    .product-item-photo {
        width: 100%;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-item-photo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 5px;
    }
    .product-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    .nav-brand .item-img img {
        width: 100px;
        height: 60px;
        object-fit: contain;
        display: block;
        margin: auto;
    }
/* ==== Sidebar Filter Styling ==== */
.sidebar {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    padding: 20px;
    margin-bottom: 30px;
}

.filter-group {
    margin-bottom: 25px;
}

.filter-group h5 {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 12px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 6px;
}

.filter-group label {
    display: block;
    font-size: 14px;
    color: #444;
    cursor: pointer;
    margin-bottom: 8px;
    transition: 0.2s ease;
}

.filter-group label:hover {
    color: #007bff;
}

.filter-group input[type="checkbox"] {
    margin-right: 8px;
    accent-color: #007bff; /* modern browsers */
}

/* ==== Price Range Section ==== */
#price_min,
#price_max {
    width: 100px;
    padding: 6px 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
    transition: border-color 0.3s ease;
}

#price_min:focus,
#price_max:focus {
    border-color: #007bff;
}

#applyPrice {
    margin-top: 8px;
    padding: 7px 15px;
    background: #E52E04;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s ease;
    width: 100%;
}

#applyPrice:hover {
    background: #0056b3;
}

/* ==== Product Card Styling ==== */
.product-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.08);
    text-align: center;
    padding: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: contain;
    border-radius: 8px;
    margin-bottom: 10px;
}

.product-card h6 {
    font-size: 15px;
    font-weight: 500;
    color: #333;
    margin-bottom: 4px;
}

.product-card .price {
    font-size: 15px;
    color: #007bff;
    font-weight: 600;
}

/* ==== Pagination Styling ==== */
.pagination-wrapper {
    text-align: center;
    margin-top: 25px;
}

.pagination a,
.pagination span {
    display: inline-block;
    margin: 0 4px;
    padding: 6px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    color: #007bff;
    text-decoration: none;
    transition: all 0.2s ease;
}

.pagination a:hover {
    background: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination .active span {
    background: #007bff;
    color: #fff;
    border-color: #007bff;
}

/* ==== Responsive ==== */
@media (max-width: 768px) {
    .sidebar {
        margin-bottom: 20px;
    }

    #price_min,
    #price_max {
        width: 70px;
    }

    #applyPrice {
        margin-top: 6px;
        display: block;
        width: 100%;
    }
}

</style>
<section class="pt-3 pb-3 page-info section-padding border-bottom bg-white">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <a href="#"><strong><span class="mdi mdi-home"></span> Home</strong></a> 
          <span class="mdi mdi-chevron-right"></span> 
            <a href="{{ route('frontend.shop') }}">Shop</a>
            @if(isset($cat))
                <span class="mdi mdi-chevron-right"></span> 
                <a href="#">{{ $cat->name ?? '' }} </a>
            @endif
        </div>
      </div>
    </div>
  </section>
  <section class="shop-list section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="shop-filters">
            <div id="accordion">
              <div class="card">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                      aria-controls="collapseOne">
                      Category <span class="mdi mdi-chevron-down float-right"></span>
                    </button>
                  </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body card-shop-filters">
                    <div class="filter-options-item filter-options-categori">
                        <div class="filter-options-content">
                            <ol class="items" style="padding-left: 0px">
                                @foreach($allCat as $cat)
                                    <div class="custom-control custom-checkbox">
                                        <input 
                                            type="checkbox"
                                            class="custom-control-input filter-category"
                                            id="cat_{{ $cat->id }}"
                                            value="{{ $cat->id }}"
                                        >
                                        <label class="custom-control-label" for="cat_{{ $cat->id }}">
                                            {{ $cat->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>

                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                      aria-expanded="false" aria-controls="collapseTwo">
                      Price <span class="mdi mdi-chevron-down float-right"></span>
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body card-shop-filters">
                    <div class="filter-options-item filter-options-price">
                        <input type="number" id="price_min" placeholder="Min"> -
                        <input type="number" id="price_max" placeholder="Max">
                        <button id="applyPrice">Apply</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="left-ad mt-4">
            <img class="img-fluid" src="http://via.placeholder.com/254x557" alt="">
          </div>
        </div>
        <div class="col-md-9">
          <a href="#"><img class="img-fluid mb-3" src="img/shop.jpg" alt=""></a>
          <div class="shop-head">
            <a href="#"><span class="mdi mdi-home"></span> Home</a> <span class="mdi mdi-chevron-right"></span> 
            @if(isset($cat))
                <span class="mdi mdi-chevron-right"></span> 
                <a href="#">{{ $cat->name ?? '' }} </a>
            @endif
            <div class="btn-group float-right mt-2">
              <a href="{{ route('frontend.shop') }}" class="btn btn-secondary text-white">
                <i class="fa-solid fa-broom"></i> Clear filter
            </a>
              
            </div>
            @if(isset($cat))
                <h5 class="mb-3">{{ $cat->name ?? '' }}</h5>
            @endif
          </div>
          <div class="shop-products">
                <div id="productContainer">
                    @include('frontend.partials.product_list', ['products' => $products])
                </div>
            </div>
          {!! $products->links() !!}
        </div>
      </div>
    </div>
  </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            function fetchProducts() {
                let categories = [];
                $('.filter-category:checked').each(function() {
                    categories.push($(this).val());
                });

                let brands = [];
                $('.filter-brand:checked').each(function() {
                    brands.push($(this).val());
                });

                let price_min = $('#price_min').val();
                let price_max = $('#price_max').val();

                $.ajax({
                    url: "{{ route('frontend.shop') }}",
                    method: 'GET',
                    data: {
                        'categories[]': categories,
                        'brands[]': brands,
                        price_min: price_min,
                        price_max: price_max
                    },
                    beforeSend: function() {
                        $('#productContainer').html('<p class="text-center">Loading...</p>');
                    },
                    success: function(data) {
                        $('#productContainer').html(data);
                    }
                });

            }

            // Trigger filters
            $('.filter-category, .filter-brand').on('change', fetchProducts);
            $('#applyPrice').on('click', fetchProducts);

            // Pagination AJAX
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#productContainer').html(data);
                        $('html, body').animate({ scrollTop: 0 }, 'fast');
                    }
                });
            });
        });
    </script>

@endpush
