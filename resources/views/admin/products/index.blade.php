@extends('admin.page', ['title' => "Продукты"])

@section('content')
    <h4 class="center">Продукты</h4>

    <div class="row products">
        <div class="col s3">
            <div class="collection">
                <a href="{{ route('admin.products.index') }}" class="collection-item grey lighten-3"><strong>Категории</strong></a>
                @foreach($categories as $category)
                    <a href="{{ route('admin.products.index').'?category='.$category->id }}" class="collection-item depth-{{ $category->depth }}{{ request('category') == $category->id ? ' active' : '' }}">{{ $category->name }}{!! $category->products_count ? '<span class="badge teal white-text">' . $category->products_count . '</span>' : '' !!}</a>
                @endforeach
            </div>
        </div>
        @if (request('category'))
            <div class="col s9">
                <p><a href="{{ route('admin.products.create') }}" class="btn waves-effect waves-light"><i class="material-icons left">add_circle</i> Добавить</a></p>

                @if ($items->count())
                    <table id="table_items">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Фото</th>
                                <th>Название</th>
                                <th>Alias</th>
                                <th>Цена</th>
                                <th>Доступность</th>
                                <th>Доп. инфо</th>
                                <th class="filter-false btn-collumn" data-sorter="false"></th>
                                <th class="filter-false btn-collumn" data-sorter="false"></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="9" class="pager form-inline">
                                    <button type="button" class="btn btn-small waves-effect waves-light first"><i class="material-icons">first_page</i></button>
                                    <button type="button" class="btn btn-small waves-effect waves-light prev"><i class="material-icons">navigate_before</i></button>
                                    <span class="pagedisplay"></span> <!-- this can be any element, including an input -->
                                    <button type="button" class="btn btn-small waves-effect waves-light next"><i class="material-icons">navigate_next</i></button>
                                    <button type="button" class="btn btn-small waves-effect waves-light last"><i class="material-icons">last_page</i></button>
                                    <select class="pagesize" title="Размер страницы">
                                        <option selected="selected" value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <select class="gotoPage" title="Номер страницы"></select>
                                </th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>@if ($item->image)<img src='/images/small/{{ $item->img_url.$item->image }}' alt='' />@endif</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->available ? 'есть' : 'нет' }}</td>
                                    <td>
                                        <ul class="product-properties">
                                            {!! $item->properties->style ? '<li><strong>Стиль:</strong> '.$item->properties->style.'</li>' : '' !!}
                                            {!! $item->properties->material ? '<li><strong>Материал:</strong> '.$item->properties->material.'</li>' : '' !!}
                                            {!! $item->properties->price ? '<li><strong>Стоимость:</strong> '.$item->properties->price.'</li>' : '' !!}
                                            {!! $item->properties->equipment ? '<li><strong>Комплектация:</strong> '.$item->properties->equipment.'</li>' : '' !!}
                                            {!! $item->properties->size ? '<li><strong>Размер:</strong> '.$item->properties->size.'</li>' : '' !!}
                                            {!! $item->properties->color ? '<li><strong>Цвет:</strong> '.$item->properties->color.'</li>' : '' !!}
                                            {!! $item->properties->purpose ? '<li><strong>Назначение:</strong> '.$item->properties->purpose.'</li>' : '' !!}
                                            {!! $item->properties->type ? '<li><strong>Тип мебели:</strong> '.$item->properties->type.'</li>' : '' !!}
                                            {!! $item->properties->kind ? '<li><strong>Вид мебели:</strong> '.$item->properties->kind.'</li>' : '' !!}
                                            {!! $item->properties->doors ? '<li><strong>Кол-во дверей:</strong> '.$item->properties->doors.'</li>' : '' !!}
                                        </ul>
                                    </td>
                                    <td><a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-small waves-effect waves-light"><i class="material-icons">edit</i></a></td>
                                    <td><button onclick="confirmDelete(this, '{{ $item->id }}', '{{ route('admin.products.destroy', $item->id) }}')" class="btn btn-small waves-effect waves-light red darken-2"><i class="material-icons">delete</i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-items"></div>
                @endif
            </div>
        @endif
    </div>
@endsection
