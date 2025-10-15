@if ($reels->isNotEmpty())
<section class="team-section reel-section">
    <div class="left-bot-bg">
        <img src="{{ asset('front_assets/images/background/bg-1.png') }}" alt="" loading="lazy">
    </div>
    <div class="right-top-bg">
        <img src="{{ asset('front_assets/images/background/bg-6.png') }}" alt="" loading="lazy">
    </div>

    <div class="auto-container">
        <h2 class="team-heading" style="padding: 20px;">Our Reels</h2>
        <div class="owl-carousel reels-carousel owl-theme">
            @foreach ($reels as $reel)
            <div class="item">
                <a href="{{ $reel['permalink'] }}" target="_blank">
                    <video src="{{ $reel['media_url'] }}"
                        controls
                        autoplay
                        muted
                        loop
                        preload="metadata"
                        style="width:100%;border-radius:10px;">
                    </video>
                </a>
                @if(!empty($reel['caption']))
                <p style="text-align:center;margin-top:8px;">{{ Str::limit($reel['caption'], 80) }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif