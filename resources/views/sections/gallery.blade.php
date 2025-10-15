@if (!empty($images))
<section class="team-section">
    <div class="left-bot-bg"><img src="{{ asset('front_assets/images/background/bg-1.png') }}" alt="" title="" loading="lazy"></div>
    <div class="right-top-bg"><img src="{{ asset('front_assets/images/background/bg-6.png') }}" alt="" title="" loading="lazy"></div>
    <div class="auto-container">
        <h2 class="team-heading" style="padding: 20px;">Our Gallery</h2>
        <div class="owl-carousel gallery-carousel owl-theme">
            @foreach ($images as $image)
            <div class="item">
                <a href="{{ asset($image->file) }}" data-fancybox="wedding">
                    <img src="{{ asset($image->file) }}" alt="" loading="lazy">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif