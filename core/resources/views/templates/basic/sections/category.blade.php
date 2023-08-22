@php
$content = getContent('category.content', true);
$categories = App\Models\Category::with('company')
            ->where('status', 1)
            ->whereHas('company', function ($q) {
                $q->where('status', 1);
            })
            ->latest()
            ->limit(0)->get();
@endphp

@if($categories->count())
<section class="pt-100 pb-100 section--bg category-section glass--overlay">
    <div class="circle-shape"></div>
    <div class="square-shape"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-header text-center mb-4">
                    <h2 class="section-title style--two">{{ __(@$content->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="category-list">
                    @forelse ($categories as $category)
                        <a href="{{ route('category.company', $category->id) }}" class="category-list__single">
                            @php
                                echo @$category->icon;
                            @endphp
                            <span>{{ __(@$category->name) }}</span>
                        </a>
                    @empty
                        <span>@lang('No Category Yet')</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endif
