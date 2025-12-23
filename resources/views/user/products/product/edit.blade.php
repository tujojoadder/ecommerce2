@extends('layouts.user.app', ['pageTitle' => $pageTitle])
@section('content')
    @php
        $route = Request::is('user/product/edit*');
        $queryString = $_SERVER['QUERY_STRING'] ?? '';
    @endphp
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <style>
        #editor-container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
        }

        .ck-editor__editable {
            min-height: 150px;
            max-height: 150px;
            overflow-y: auto;
            resize: vertical;
            /* Allows vertical resizing */
        }
    </style>
    <div class="main-content-body">
        <!-- Col -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <p class="card-title my-0">{{ $pageTitle }}</p>
                <div class="d-flex">
                    <a data-bs-target="#formSettingModal" data-bs-toggle="modal" class="btn btn-secondary text-white me-2">
                        <i class="fas fa-cog d-inline"></i>
                    </a>
                    {{-- <a href="javascript:;" id="uploadBulkFile" class="btn btn-secondary text-white me-2"><i class="fas fa-upload d-inline"></i> {{ __('messages.bulk_upload') }}</a>
                    <a href="{{ route('download.product.bulk') }}" class="btn btn-secondary text-white me-2"><i class="fas fa-download d-inline"></i> {{ __('messages.download_bulk_file') }}</a> --}}
                    <a href="{{ route('user.product.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-list d-inline"></i> {{ __('messages.product') }} {{ __('messages.list') }}
                    </a>
                    <a href="{{ route('user.client-group.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-layer-group d-inline"></i> {{ __('messages.product') }} {{ __('messages.group') }}
                    </a>
                    <a href="javascript:;" data-bs-target="#youtube-modal" data-bs-toggle="modal"
                        id="youtubeModalInstructionBtn"
                        data-link="https://www.youtube.com/embed/TJKc2DTtst8?si=GeqmIXdKxyVExgnL">
                        <img width="100" class="border p-2 rounded-lg bg-white"
                            src="{{ asset('dashboard/img/youtube.jpg') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="data_id" value="{{ $product->id }}">
                    <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_name') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" id="product_name" name="name" value="{{ $product->name ?? 'N/A' }}">
                            <label class="animated-label active-label" for="product_name"><i class="fab fa-product-hunt"></i>
                                {{ __('messages.product') }} {{ __('messages.name') }}</label>
                            <span class="text-danger small" id="product_name_Error" style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $product->subtitle }}">
                            <label class="animated-label active-label" for="subtitle"><i class="fab fa-product-hunt"></i>
                                {{ __('messages.product') }} {{ __('messages.subtitle') }}</label>
                            <span class="text-danger small" id="subtitle_Error" style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="item_code" name="item_code" value="{{ $product->item_code }}">
                            <label class="animated-label active-label" for="item_code"><i class="fab fa-product-hunt"></i>
                                {{ __('messages.item_code') }}</label>
                            <span class="text-danger small" id="item_code_Error" style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">

                            <select name="condition" id="condition" class="form-control" data-bs-placement="top"
                                data-bs-toggle="tooltip-primary" title="{{ __('messages.condition') }}">
                                <option value="">Select Condition</option>
                                <option value="New" {{ $product->condition == 'New' ? 'selected' : '' }}>New</option>
                                <option value="Used" {{ $product->condition == 'Used' ? 'selected' : '' }}>Used</option>
                            </select>
                            <span class="text-danger small" id="condition_Error" style="color: red !important;"></span>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 d-none">
                        <div class="form-group">
                            <input type="text" class="form-control" id="description" name="description">
                            <label class="animated-label active-label" for="description"><i class="fas fa-info-circle"></i>
                                {{ __('messages.description') }}</label>
                            <span class="text-danger small" id="description_Error" style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="main_price" name="main_price" value="{{ $product->main_price }}">
                            <label class="animated-label active-label" for="main_price">{{ config('company.currency_symbol') }}
                                {{ __('messages.main_price') }}</label>
                            <span class="text-danger small" id="main_price_Error" style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_buying_price') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" class="form-control" id="buying_price" name="buying_price" value="{{ $product->buying_price }}">
                            <label class="animated-label active-label" for="buying_price">{{ config('company.currency_symbol') }}
                                {{ __('messages.buying') }} {{ __('messages.price') }}</label>
                            <span class="text-danger small" id="buying_price_Error"
                                style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_selling_price') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" class="form-control" id="selling_price" name="selling_price" value="{{ $product->selling_price }}">
                            <label class="animated-label active-label" for="selling_price"
                                id="selling_price_label">{{ config('company.currency_symbol') }}
                                {{ __('messages.selling') }} {{ __('messages.price') }}</label>
                            <span class="text-danger small" id="selling_price_Error"
                                style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_wholesale_price') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" class="form-control" id="wholesale_price" name="wholesale_price">
                            <label class="animated-label" for="wholesale_price">{{ config('company.currency_symbol') }}
                                {{ __('messages.wholesale_price') }}</label>
                            <span class="text-danger small" id="wholesale_price_Error"
                                style="color: red !important;"></span>
                        </div>
                    </div>
                    <div
                        class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('products_unit_id') == 1 ? '' : 'd-none' }}">
                        <div class="d-flex">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                title="{{ __('messages.unit') }}">
                                <select name="unit_id" class="form-control select2" id="unit_id">
                                </select>
                            </div>
                            <a id="unitModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i
                                    class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="unit_id_Error" style="color: red !important;"></span>
                    </div>
                    <div
                        class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('products_color_id') == 1 ? '' : 'd-none' }}">
                        <div class="d-flex">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                title="{{ __('messages.color') }}">
                                <select name="color_id" class="form-control select2" id="color_id">
                                </select>
                            </div>
                            <span class="text-danger small" id="color_id_Error" style="color: red !important;"></span>
                            <a id="productColorModalBtn" class="add-btn btn btn-success" type="button"
                                href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div
                        class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('products_size_id') == 1 ? '' : 'd-none' }}">
                        <div class="d-flex">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                title="{{ __('messages.size') }}">
                                <select name="size_id" class="form-control select2" id="size_id">
                                </select>
                            </div>
                            <span class="text-danger small" id="size_id_Error" style="color: red !important;"></span>
                            <a id="productSizeModalBtn" class="add-btn btn btn-success" type="button"
                                href="javascript:;"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                        <div class="d-flex">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                title="{{ __('messages.brand') }}">
                                <select name="brand_id" class="form-control select2" id="brand_id"></select>
                            </div>
                            <a id="brandModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i
                                    class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="brand_id_Error" style="color: red !important;"></span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_carton') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" class="form-control" id="carton" name="carton" value="{{ $product->carton }}">
                            <label class="animated-label active-label" for="carton"><i class="fas fa-box"></i>
                                {{ __('messages.carton') }}</label>
                            <span class="text-danger small" id="carton_Error" style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_opening_stock') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" class="form-control" id="opening_stock" name="opening_stock" value="{{ $product->opening_stock }}">
                            <label class="animated-label active-label" for="opening_stock"><i class="fas fa-balance-scale"></i>
                                {{ __('messages.opening_stock') }}</label>
                            <span class="text-danger small" id="opening_stock_Error"
                                style="color: red !important;"></span>
                        </div>
                    </div>
                     <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_stock_warning') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="number" class="form-control" id="stock_warning" name="stock_warning" value="{{ $product->stock_warning }}">
                            <label class="animated-label active-label" for="stock_warning"><i class="fas fa-store"></i>
                                {{ __('messages.stock') }} {{ __('messages.warning') }}
                                {{ __('messages.quantity') }}</label>
                        </div>
                        <span class="text-danger small" id="stock_warning_Error" style="color: red !important;"></span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="number" class="form-control" id="shipping_in_dhaka" name="shipping_in_dhaka" value="{{ $product->shipping_in_dhaka }}">
                            <label class="animated-label active-label" for="shipping_in_dhaka"><i class="fas fa-store"></i>
                                {{ __('messages.shipping_in_dhaka') }}</label>
                        </div>
                        <span class="text-danger small" id="shipping_in_dhaka_Error" style="color: red !important;"></span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <input type="number" class="form-control" id="shipping_out_dhaka" name="shipping_out_dhaka" value="{{ $product->shipping_in_dhaka }}">
                            <label class="animated-label active-label" for="shipping_out_dhaka"><i class="fas fa-store"></i>
                                {{ __('messages.shipping_out_dhaka') }}</label>
                        </div>
                        <span class="text-danger small" id="shipping_out_dhaka_Error" style="color: red !important;"></span>
                    </div>
                    <div
                        class="col-xl-6 col-lg-6 col-md-6 {{ config('products_custom_barcode_no') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" id="custom_barcode_no" name="custom_barcode_no">
                            <label class="animated-label" for="custom_barcode_no"><i class="fas fa-barcode"></i>
                                {{ __('messages.barcode_number') }}</label>
                            <span class="text-danger small" id="custom_barcode_no_Error"
                                style="color: red !important;"></span>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 {{ config('products_imei_no') == 1 ? '' : 'd-none' }}">
                        <div class="form-group">
                            <input type="text" class="form-control" id="imei_no" name="imei_no">
                            <label class="animated-label" for="imei_no"><i class="fas fa-barcode"></i>
                                {{ __('messages.imei_no') }}</label>
                            <span class="text-danger small" id="imei_no_Error" style="color: red !important;"></span>
                        </div>
                    </div>

                    <div
                        class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('products_group_id') == 1 ? '' : 'd-none' }}">
                        <div class="d-flex">
                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                title="{{ __('messages.group') }}">
                                <select name="group_id" id="group_id" class="form-control">
                                </select>
                            </div>
                            <a id="groupModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;"><i
                                    class="fas fa-plus"></i></a>
                        </div>
                        <span class="text-danger small" id="group_id_Error" style="color: red !important;"></span>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="form-group mb-2">
                            <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                <span class="form-switch-description tx-15 me-2">Best Selling Product?</span>
                                <input type="checkbox" name="is_bestsell" id="is_bestsell" class="form-switch-input" {{ $product->is_bestsell == 1 ? 'checked' : '' }} >
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="form-group mb-2">
                            <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                <span class="form-switch-description tx-15 me-2">Special Product?</span>
                                <input type="checkbox" name="is_special" id="is_special" class="form-switch-input" {{ $product->is_special == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="form-group mb-2">
                            <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                <span class="form-switch-description tx-15 me-2">New Arrival Product?</span>
                                <input type="checkbox" name="is_newarrival" id="is_newarrival" class="form-switch-input" {{ $product->is_newarrival == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="form-group mb-2">
                            <label class="w-100 form-control d-flex justify-content-between py-1 checkbox-input">
                                <span class="form-switch-description tx-15 me-2">Most Review Product?</span>
                                <input type="checkbox" name="is_mostreview" id="is_mostreview" class="form-switch-input" {{ $product->is_mostreview == 1 ? 'checked' : '' }}>
                                <span class="form-switch-indicator form-switch-indicator-lg"></span>
                            </label>
                        </div>
                    </div>
                    @if (config('sidebar.warehouse') == 1)
                        <div class="{{ config('products_warehouse_id') == 1 ? '' : 'd-none' }} form-group mb-3 col-6">
                            <div class="d-flex" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                title="{{ __('messages.ware_house') }}">
                                <div class="input-group">
                                    <select name="warehouse_id" id="warehouse_id" class="form-control select2"></select>
                                </div>
                                <a data-bs-toggle="modal" id="warehouseBtn" data-bs-target="#warehouseModal"
                                    class="add-btn btn btn-success" href="javascript:;"><i class="fas fa-plus"></i></a>
                            </div>
                            <span class="text-danger small" id="warehouse_id_Error"
                                style="color: red !important;"></span>
                        </div>
                    @endif
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h3 class="text-center">Product Images</h3>
                                    <div
                                        class="form-group col-xl-6 col-lg-6 col-md-6 {{ config('products_image') == 1 ? '' : 'd-none' }}">
                                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                            title="{{ __('messages.main') }} {{ __('messages.image') }}">
                                            <input type="file" accept="image/*" name="image" class="form-control image"
                                                id="image" placeholder="" id="{{ __('messages.image') }}">
                                                <span class="text-danger small" id="image_Error" style="color: red !important;"></span>
                                            </div>
                                            <span class="text-danger small" style="color: red !important;">Width: 420px * Height:512px</span>
                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <div id="image-show" class="{{ $route ? 'mt-2 p-1' : '' }}">
                                                    @if ($route)
                                                        <img src="{{ asset('storage/product/' . $product->image) }}" alt="" style="height: 100px !important">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6">
                                        <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                            title="{{ __('messages.subimage') }}">
                                            <input type="file" accept="image/*" name="subimage[]" class="form-control subimage"
                                                id="subimage" multiple>
                                            <span class="text-danger small" id="subimage_Error" style="color: red !important;"></span>
                                        </div>
                                        <span class="text-danger small" style="color: red !important;">Width: 420px * Height:512px</span>

                                        <!-- Preview Images এখানে দেখাবে -->
                                        <div id="preview" class="d-flex flex-wrap mt-2"></div>
                                        @foreach ($product->images as $imgs)
                                           <img src="{{ asset('storage/product/subimages/'. $imgs->image) }}" data-large-image="{{ asset('storage/product/subimages/'. $imgs->image) }}" style="width: 50px;height: 50px;border: 1px solid #222" alt="">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h3 class="text-center">Category Information</h3>
                                    <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                        <div class="d-flex">
                                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                                title="{{ __('messages.select') }} {{ __('messages.category') }}">
                                                <select name="category_id" id="category_id" class="form-control" required>
                                                </select>
                                            </div>
                                            <a id="categoryModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                        <span class="text-danger small" id="category_id_Error" style="color: red !important;"></span>
                                    </div>
                                    <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                        <div class="d-flex">
                                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                                title="{{ __('messages.select') }} {{ __('messages.subcategory') }}">
                                                <select name="subcategory_id" id="subcategory_id" class="form-control">
                                                </select>
                                            </div>
                                            <a id="subcategoryModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                        <span class="text-danger small" id="subcategory_id_Error" style="color: red !important;"></span>
                                    </div>
                                    <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                        <div class="d-flex">
                                            <div class="input-group" data-bs-placement="top" data-bs-toggle="tooltip-primary"
                                                title="{{ __('messages.select') }} {{ __('messages.subsubcategory') }}">
                                                <select name="subsubcategory_id" id="subsubcategory_id" class="form-control">
                                                </select>
                                            </div>
                                            <a id="subsubcategoryModalBtn" class="add-btn btn btn-success" type="button" href="javascript:;">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                        </div>
                                        <span class="text-danger small" id="subsubcategory_id_Error" style="color: red !important;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="col-xl-12 col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h3 class="text-center">Meta Information</h3>
                                    <div class="col-xl-12 col-lg-12 col-md-12 mt-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="meta_seo" name="meta_seo" value="{{ $product->meta_seo }}">
                                            <label class="animated-label" for="meta_seo"><i class="fas fa-store"></i>
                                                {{ __('messages.meta_seo') }}</label>
                                        </div>
                                        <span class="text-danger small" id="meta_seo_Error" style="color: red !important;"></span>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $product->meta_title }}">
                                            <label class="animated-label" for="meta_title"><i class="fas fa-store"></i>
                                                {{ __('messages.meta_title') }}</label>
                                        </div>
                                        <span class="text-danger small" id="meta_title_Error" style="color: red !important;"></span>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="meta_description" name="meta_description" value="{{ $product->meta_description }}">
                                            <label class="animated-label" for="meta_description"><i class="fas fa-store"></i>
                                                {{ __('messages.meta_description') }}</label>
                                        </div>
                                        <span class="text-danger small" id="meta_description_Error" style="color: red !important;"></span>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 mt-4">
                                        <div class="form-group row">
                                            <div class="col-10">
                                                <label>Meta Keywords (comma separated):</label><br>
                                                <input type="text" id="tagsInput" class="form-control" placeholder="Type and press enter" value="{{ $product->meta_description }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <label for="">Enter Product Description/Information</label>
                        <textarea name="information" id="information" class="editor" placeholder="Enter Product Information">{{ $product->information }}</textarea>
                        <span class="text-danger small" id="information_Error" style="color: red !important;"></span>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 mt-4">
                        <label for="">Enter Product specification</label>
                        <textarea name="specification" id="specification" class="editor" placeholder="Enter Product specification">{{ $product->specification }}</textarea>
                        <span class="text-danger small" id="specification_Error" style="color: red !important;"></span>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 mt-4">
                        <label for="">Enter Product guarantee</label>
                        <textarea name="guarantee" id="guarantee" class="editor" placeholder="Enter Product guarantee">{{ $product->guarantee }}</textarea>
                        <span class="text-danger small" id="guarantee_Error" style="color: red !important;"></span>
                    </div>
                </div>
                <input type="hidden" id="row_id" value="{{ $product->id }}">


                <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-3">
                    <button class="add-to-cart btn btn-success btn-block" id="updateProduct" onclick="updateProduct();"><i
                            class="fas fa-plus"></i> {{ __('messages.update') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Col -->

    </div>
    @include('user.products.product.form-setting-modal')
    @include('user.client.group.client-group-modal')
    @include('user.products.product.asset.asset-modal')
    @include('user.products.product.group.product-group-modal')
    @include('user.products.product.unit.product-unit-modal')
    @include('user.products.warehouse.warehouse-modal')
    @include('user.brand.brand-modal')
    @include('user.category.category-modal')
    @include('user.subcategory.sub-cat-modal')
    @include('user.subsubcategory.subsub-cat-modal')
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="{{ asset('dashboard/js/select2-fetch.js') }}"></script>
    <script src="{{ asset('dashboard/js/append.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
        var input = document.querySelector('#tagsInput');
        var tagify = new Tagify(input, {
            delimiters: ", ",
            trim: true,
            dropdown: {
                enabled: 0
            }
        });

        function getTags() {
            return tagify.value.map(tag => tag.value);
        }
    </script>
    <script>
        let informationEditor, specificationEditor, guaranteeEditor;

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor.create(document.querySelector('#information'))
                .then(editor => {
                    informationEditor = editor;
                })
                .catch(error => console.error(error));

            ClassicEditor.create(document.querySelector('#specification'))
                .then(editor => {
                    specificationEditor = editor;
                })
                .catch(error => console.error(error));

            ClassicEditor.create(document.querySelector('#guarantee'))
                .then(editor => {
                    guaranteeEditor = editor;
                })
                .catch(error => console.error(error));
        });
    </script>

    <script>
        $(document).ready(function() {
            let save_method = 'add';
            let category_id = null;
            $("#productColorModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('color');
            });
            $("#categoryModalBtn").click(function() {
                $("#categoryModal").modal("show");
                save_method = 'add';
                category_id = null;
                $('#categoryForm')[0].reset();
                $('#formMethod').val('POST');
                $('#categoryModalLabel').text("{{ __('messages.add') }} {{ __('messages.category') }}");
                $('#saveCategory').text("{{ __('messages.add') }}");
                $('#categoryModal').modal('show');
            });

            $("#subcategoryModalBtn").click(function() {
                $("#subcategoryModal").modal("show");
                save_method = 'add';
                category_id = null;
                $('#categoryForm')[0].reset();
                $('#formMethod').val('POST');
                $('#categoryModalLabel').text("{{ __('messages.add') }} {{ __('messages.subcategory') }}");
                $('#saveCategory').text("{{ __('messages.add') }}");
                $('#subcategoryModal').modal('show');
            });
            $("#subsubcategoryModalBtn").click(function() {
                save_method = 'add';
                edit_id = null;

                $('#subsubcategoryModal').modal("show");
            });

             $('#subsubcategoryform').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                // decide URL based on save_method
                let url = (save_method === 'add')
                    ? "{{ route('user.subsubcategory.store') }}"
                    : "{{ url('user/subsubcategory/update') }}/" + edit_id;

                if (save_method === 'edit') {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#subsubcategoryModal').modal('hide');
                        $('#subcategoryTable').DataTable().ajax.reload();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: (save_method === 'add') ? 'SubSubcategory added!' : 'SubSubcategory updated!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(() => {
                            getSubSubCategoryInfo('/get-sub-sub-cateogry-info', res.id);
                        }, 500);

                        // reset state
                        save_method = 'add';
                        edit_id = null;
                    },
                    error: function(err) {
                        let errors = err.responseJSON.errors;
                        let msg = '';
                        $.each(errors, function(key, value) {
                            msg += value[0] + '<br>';
                        });
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });





            $("#brandModalBtn").click(function() {
                $("#brandModal").modal("show");
            });
            $("#productSizeModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('size');
            });
            $("#productBrandModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('brand');
            });
            $("#unitModalBtn").click(function() {
                $("#unitProductModal").modal("show");
            });
            $("#groupModalBtn").click(function() {
                $("#groupProductModal").modal("show");
            });

            @if (config('products_sale_price_with_percentage') == 1)
                $("#buying_price").on('keyup change', function() {
                    var buying_price = parseFloat($(this).val()) || 0;
                    var percentage = parseFloat("{{ siteSettings()->sale_price_percentage }}") || 0;
                    var selling_price = (buying_price * percentage / 100) + buying_price;
                    $("#selling_price").val(selling_price ? selling_price.toFixed(0) : 0);
                    $("#selling_price_label").addClass('active-label');
                });

                // $("#selling_price").on('keyup change', function() {
                //     var selling_price = parseFloat($(this).val()) || 0;
                //     var percentage = parseFloat("{{ siteSettings()->sale_price_percentage }}") || 0;
                //     var buying_price = percentage ? (selling_price / (percentage / 100)) : selling_price;
                //     $("#buying_price").val(buying_price ? buying_price.toFixed(0) : 0);
                //     $("#buying_price_label").addClass('active-label');
                // });
            @endif
        });
        $(document).ready(function() {
            fetchCategories();
            $("#subcategory_id").select2({
                placeholder: 'Select Sub Category'
            });

            $("#subsubcategory_id").select2({
                placeholder: 'Select Sub Sub Category'
            });

            $("#category_id").on('change', function() {
                var category_id = $(this).val();

                clearSubCategory(true);
                clearSubSubCategory(true);

                if (category_id) {
                    setTimeout(() => {
                        getSubCategoryInfo('/get-sub-cateogry-info', {{ $product->subcategory_id }});
                        fetchSubCategories(category_id);
                    }, 500);
                }
            });

            // Subcategory change handler
            $("#subcategory_id").on('change', function() {
                var category_id = $("#category_id").val();
                var subcategory_id = $(this).val();

                clearSubSubCategory(true);

                if (category_id && subcategory_id) {
                    setTimeout(() => {
                        getSubSubCategoryInfo('/get-sub-sub-cateogry-info', {{ $product->subsubcategory_id }});
                        fetchSubSubCategories(category_id, subcategory_id);
                    }, 500);
                }
            });

            function clearSubCategory(fullReset = false) {
                if (fullReset) {
                    $("#subcategory_id").empty().append('<option value="">Select Sub Category</option>').trigger(
                        'change');
                } else {
                    $("#subcategory_id").val('').trigger('change');
                }
            }

            function clearSubSubCategory(fullReset = false) {
                if (fullReset) {
                    $("#subsubcategory_id").empty().append('<option value="">Select Sub Sub Category</option>')
                        .trigger('change');
                } else {
                    $("#subsubcategory_id").val('').trigger('change');
                }
            }
        });


        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        $(document).ready(function() {
            $('#image').change(function() {
                $('#image-show').html('');
                setTimeout(() => {
                    var file = this.files[0];
                    if (file) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#image-show').append("<img class='rounded-pill' src=" + e.target
                                .result + ">");
                            $('#image-show').addClass('card card-body mt-2 p-1');
                            $('#image-show').show();
                        };
                        reader.readAsDataURL(file);
                    }
                }, 200);
            });
        });
    </script>

    <script>
        // for asset modal
        $(document).ready(function() {
            $("#productColorModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('color');
            });
            $("#productSizeModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('size');
            });
            $("#productBrandModalBtn").click(function() {
                $("#assetProductModal").modal("show");
                $("#asset_type").val('brand');
            });
            $("#unitModalBtn").click(function() {
                $("#unitProductModal").modal("show");
            });
            $("#groupModalBtn").click(function() {
                $("#groupProductModal").modal("show");
            });

            @if (config('products_sale_price_with_percentage') == 1)
                $("#buying_price").on('keyup change', function() {
                    var buying_price = parseFloat($(this).val()) || 0;
                    var percentage = parseFloat("{{ siteSettings()->sale_price_percentage }}") || 0;
                    var selling_price = (buying_price * percentage / 100) + buying_price;
                    $("#selling_price").val(selling_price ? selling_price.toFixed(0) : 0);
                    $("#selling_price_label").addClass('active-label');
                });

                // $("#selling_price").on('keyup change', function() {
                //     var selling_price = parseFloat($(this).val()) || 0;
                //     var percentage = parseFloat("{{ siteSettings()->sale_price_percentage }}") || 0;
                //     var buying_price = percentage ? (selling_price / (percentage / 100)) : selling_price;
                //     $("#buying_price").val(buying_price ? buying_price.toFixed(0) : 0);
                //     $("#buying_price_label").addClass('active-label');
                // });
            @endif
        });

        $(document).ready(function() {
            fetchWarehouses();
            fetchProductGroups();
            fetchProductColors();
            fetchProductSizes();
            fetchProductBrands();
            fetchProductUnits();
            setTimeout(() => {
                getProductGroupInfo('/get-product-group', {{ $product->group_id }});
                getProductUnitInfo('/get-product-unit', {{ $product->unit_id }});
                getCategoryInfo('/get-cateogry-info', {{ $product->category_id }});
                getProductBrandInfo('/get-product-brand', {{ $product->brand_id }});
                // getProductColorInfo('/get-product-color', data.color_id)
                // getProductSizeInfo('/get-product-size', data.size_id)
            }, 500);
        });

        $(document).ready(function() {
            $('.image').change(function(event) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.showImage').attr('src', event.target.result);
                }
                reader.readAsDataURL(event.target.files['0']);
            });
            // select2 form input
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="carf-token"]').attr('content')
            }
        });

        function clearProductField() {
            $('#product_name').val('');
            $('#product_name_Error').text('');
            $('#product_name').removeClass('border-danger');

            $('#image').val('');
            $('#image_Error').text('');
            $('#image').removeClass('border-danger');

            $('#description').val('');
            $('#description_Error').text('');
            $('#description').removeClass('border-danger');

            $('#buying_price').val('');
            $('#buying_price_Error').text('');
            $('#buying_price').removeClass('border-danger');

            $('#selling_price').val('');
            $('#selling_price_Error').text('');
            $('#selling_price').removeClass('border-danger');

            $('#wholesale_price').val('');
            $('#wholesale_price_Error').text('');
            $('#wholesale_price').removeClass('border-danger');

            $('#unit_id').val('').trigger('change');
            $('#unit_id_Error').text('');
            $('#unit_id').removeClass('border-danger');

            $('#color_id').val('').trigger('change');
            $('#color_id_Error').text('');
            $('#color_id').removeClass('border-danger');

            $('#size_id').val('').trigger('change');
            $('#size_id_Error').text('');
            $('#size_id').removeClass('border-danger');

            $('#brand_id').val('').trigger('change');
            $('#brand_id_Error').text('');
            $('#brand_id').removeClass('border-danger');

            $('#opening_stock').val('');
            $('#opening_stock_Error').text('');
            $('#opening_stock').removeClass('border-danger');

            $('#custom_barcode_no').val('');
            $('#custom_barcode_no_Error').text('');
            $('#custom_barcode_no').removeClass('border-danger');

            $('#imei_no').val('');
            $('#imei_no_Error').text('');
            $('#imei_no').removeClass('border-danger');

            $('#carton').val('');
            $('#carton_Error').text('');
            $('#carton').removeClass('border-danger');

            $('#group_id').val('');
            $('#group_id_Error').text('');
            $('#group_id').removeClass('border-danger');

            $('#warehouse_id').val('');
            $('#warehouse_id_Error').text('');
            $('#warehouse_id').removeClass('border-danger');

            $('#stock_warning').val('');
            $('#stock_warning_Error').text('');
            $('#stock_warning').removeClass('border-danger');
        }

        $('#product-form').find('input, textarea, select').each(function() {
            var id = this.id;
            $("#" + id + "").on('keyup', function() {
                var length = $("#" + id + "").val().length;
                if (length < 1) {
                    $('#' + id + '').addClass('border-danger');
                    $('#' + id + '_Error').text('Fill the input');
                } else {
                    $('#' + id + '').removeClass('border-danger');
                    $('#' + id + '_Error').text('');
                }
            });
        });

        // add client using ajax
        function updateProduct(id) {
            var data_id = $('#row_id').val();

            // Get values
            var product_name      = $('#product_name').val();
            var subtitle          = $('#subtitle').val();
            var item_code         = $('#item_code').val();
            var condition         = $('#condition').val();
            var main_price        = $('#main_price').val();
            var buying_price      = $('#buying_price').val();
            var selling_price     = $('#selling_price').val();
            var wholesale_price   = $('#wholesale_price').val();
            var unit_id           = $('#unit_id').val();
            var color_id          = $('#color_id').val();
            var size_id           = $('#size_id').val();
            var brand_id          = $('#brand_id').val();
            var carton            = $('#carton').val();
            var opening_stock     = $('#opening_stock').val();
            var stock_warning     = $('#stock_warning').val();
            var shipping_in_dhaka = $('#shipping_in_dhaka').val();
            var shipping_out_dhaka= $('#shipping_out_dhaka').val();
            var custom_barcode_no = $('#custom_barcode_no').val();
            var imei_no           = $('#imei_no').val();
            var group_id          = $('#group_id').val();
            var warehouse_id      = $('#warehouse_id').val();
            var category_id       = $('#category_id').val();
            var subcategory_id    = $('#subcategory_id').val();
            var subsubcategory_id = $('#subsubcategory_id').val();

            var meta_title        = $('#meta_title').val();
            var meta_description  = $('#meta_description').val();
            var meta_tag = getTags();

            var information       = $('#information').val();
            var specification     = $('#specification').val();
            var guarantee         = $('#guarantee').val();

            var is_bestsell   = $('#is_bestsell').prop('checked') ? 1 : 0;
            var is_special    = $('#is_special').prop('checked') ? 1 : 0;
            var is_newarrival = $('#is_newarrival').prop('checked') ? 1 : 0;
            var is_mostreview = $('#is_mostreview').prop('checked') ? 1 : 0;

            // Files
            var image    = $('#image')[0].files[0] ?? '';
            var subimage = $('#subimage')[0].files;

            // FormData
            var formData = new FormData();
            formData.append('name', product_name);
            formData.append('subtitle', subtitle);
            formData.append('item_code', item_code);
            formData.append('condition', condition);
            formData.append('main_price', main_price);
            formData.append('buying_price', buying_price);
            formData.append('selling_price', selling_price);
            formData.append('wholesale_price', wholesale_price);
            formData.append('unit_id', unit_id ?? '');
            formData.append('color_id', color_id ?? '');
            formData.append('size_id', size_id ?? '');
            formData.append('brand_id', brand_id ?? '');
            formData.append('carton', carton);
            formData.append('opening_stock', opening_stock);
            formData.append('stock_warning', stock_warning);
            formData.append('shipping_in_dhaka', shipping_in_dhaka);
            formData.append('shipping_out_dhaka', shipping_out_dhaka);
            formData.append('custom_barcode_no', custom_barcode_no);
            formData.append('imei_no', imei_no);
            formData.append('group_id', group_id ?? '');
            formData.append('warehouse_id', warehouse_id ?? '');
            formData.append('meta_title', meta_title);
            formData.append('meta_description', meta_description);
            formData.append('information', information);
            formData.append('specification', specification);
            formData.append('guarantee', guarantee);
            formData.append('is_bestsell', is_bestsell);
            formData.append('is_special', is_special);
            formData.append('is_newarrival', is_newarrival);
            formData.append('is_mostreview', is_mostreview);

            formData.append('category_id', category_id ?? '');
            formData.append('subcategory_id', subcategory_id ?? '');
            formData.append('subsubcategory_id', subsubcategory_id ?? '');

            meta_tag.forEach(tag => formData.append('meta_tag[]', tag));

            if (image) {
                formData.append('image', image);
            }

            if (subimage.length > 0) {
                for (let i = 0; i < subimage.length; i++) {
                    formData.append('subimage[]', subimage[i]);
                }
            }

            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            var url = '{{ route('user.product.update', ':id') }}'.replace(':id', data_id);

            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                url: url,
                success: function (data) {
                    clearProductField();
                    $("#productModalClose").click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product updated successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = "{{ route('user.product.index') }}";
                    }, 1000);
                },
                error: function (error) {
                    var $errors = error.responseJSON.errors;
                    for (const key in $errors) {
                        $('#' + key + '_Error').text($errors[key]);
                        $('#' + key).addClass('border-danger');
                        toastr.error($errors[key]);
                    }
                }
            });
        }


        // add product using ajax



        // update data using ajax
    </script>
@endpush
