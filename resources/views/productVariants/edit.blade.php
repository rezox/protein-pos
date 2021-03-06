@extends('layouts.app')

@section('title')
    - Update Product Variant
@endsection

@section('content')
    @parent
    <div class="row" v-cloak>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Update Product Variant - {{ $variant->name }}
                </div>
                <div class="panel-body">
                    <form method="post" action="{{ route('product-variants.update', $variant->id) }}" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Eg: Protein Bar Flavour" required value="{{ old('name') ?: $variant->name }}" />
                                @foreach($errors->get('name') as $error)
                                    <span class="label label-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">Quantity</label>
                            <div class="col-sm-1">
                                <input type="number" id="quantity" name="quantity" class="form-control" placeholder="Eg: 2" required value="{{ old('quantity') ?: $variant->quantity }}" min="1" />
                                @foreach($errors->get('quantity') as $error)
                                    <span class="label label-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('products') ? 'has-error' : '' }}">
                            <label for="price" class="col-sm-2 control-label">Products</label>
                            <div class="col-sm-5">
                                <table class="table table-condensed table-middle table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in items">
                                            <td>
                                                @{{ item.name }}
                                                <input type="hidden" v-bind:name="'products[' + item.id + '][id]'" v-bind:value="item.id" />
                                            </td>
                                            <td>@{{ parseInt(item.price).toLocaleString() }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" v-on:click="removeItem(item)">
                                                    <i class="fa fa-trash"></i>
                                                    Remove
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <search-product
                                        src="{{ route('products.xhr.search', ['limit' => 5]) }}"
                                        :show-last-result="false"
                                        v-on:product-selected="addItem($event.product)"
                                        v-on:insufficient-stock="addItem($event.product)"
                                ></search-product>
                                @foreach($errors->get('products') as $error)
                                    <span class="label label-danger">{{ $error }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-3">
                                <button type="submit" class="btn btn-success btn-block">Update</button>
                            </div>
                            <div class="col-sm-2">
                                <a href="{{ URL::previous() === route('product-variants.edit', $variant->id) ? route('product-variants.index') : URL::previous() }}" class="btn btn-danger btn-block">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var app = new Vue({
            el: "#app",
            data: {
                items: {!! json_encode($variant->items->pluck('product')) !!}
            },
            methods: {
                addItem: function (product) {
                    if (this.items.filter(function (item) { return item.id === product.id}).length === 0) {
                        this.items.push(product);
                    }
                },
                removeItem: function (item) {
                    this.items.splice(this.items.indexOf(item), 1);
                }
            }
        });
    </script>
@endsection