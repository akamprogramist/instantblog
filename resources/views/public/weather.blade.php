<div class="card border-one text-center">
    <div class="bg-over">
        <div class="card-blog-body">
            <img src="{{ $weather['icon'] }}" alt="">
            <h4 class="mt-4">{{ $weather['location'] }}</h4>
            <p class="card-text mb-5">{{ $weather['text'] }}</p>
        </div>
    </div>
</div>
