@php
$content = getContent('faq.content', true);
$elements = getContent('faq.element', false, null, true);
@endphp
<div class="section py-5"
    style="background-image: url({{ getImage('assets/images/frontend/faq/' . @$content->data_values->image) }})">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="accordion custom--accordion" id="accordionExample">
                    @foreach ($elements as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ !$loop->first ? 'collapsed' : null }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq_{{ $loop->index }}"
                                    aria-expanded="{{ !$loop->first ? 'false' : 'true' }}">
                                    {{ __(@$item->data_values->question) }}
                                </button>
                            </h2>
                            <div id="faq_{{ $loop->index }}"
                                class="accordion-collapse collapse {{ $loop->first ? 'show' : null }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body"> {{ __(@$item->data_values->answer) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
