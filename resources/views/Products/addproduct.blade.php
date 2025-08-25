@extends('layouts.master')

@section('content')


    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Our</span> Products</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet
                            beatae optio.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="form-title">
                        <h2>Have you any question?</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur, ratione! Laboriosam est,
                            assumenda.
                            Perferendis, quo alias quaerat aliquid. Corporis ipsum minus voluptate? Dolore, esse natus!</p>
                    </div>
                    <div id="form_status"></div>
                    <div class="contact-form">
                        <form Method="POST" action="/storeProduct">
                            @csrf
                            <p>
                                <input type="text" style="width: 100%" placeholder="Name" name="name" id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">
                                        {{ $message }}
                                        </span>
                                    @enderror
                            </p>
                            <p>
                                <input type="number" step="0.1" style="width:49%" placeholder="Price" name="price" id="price">
                                    @error('price')
                                        <span class="text-danger">
                                        {{ $message }}
                                        </span>
                                    @enderror
                                <input type="number" style="width:49%" placeholder="Quantity" name="quantity" id="quantity">
                                    @error('quantity')
                                        <span class="text-danger">
                                        {{ $message }}
                                        </span>
                                    @enderror
                            </p>
                            <p><textarea name="description" id="description" cols="30" rows="10" placeholder="description"></textarea>
                                    @error('description')
                                        <span class="text-danger">
                                        {{ $message }}
                                        </span>
                                    @enderror
                            </p>
                            <p><input type="submit" value="Submit"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
