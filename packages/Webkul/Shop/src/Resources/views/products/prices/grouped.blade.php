@auth('customer')
    <p class="price-label text-sm text-zinc-500 max-sm:leading-4">
        @lang('shop::app.products.prices.grouped.starting-at')
    </p>

    <p class="font-semibold max-sm:leading-4">
        {{ $prices['final']['formatted_price'] }}
    </p>
@else
    <a
        href="{{ route('shop.customer.session.index') }}"
        class="login-prompt-link text-sm font-medium"
    >
        @lang('shop::app.products.prices.login-to-view')
    </a>
@endauth
