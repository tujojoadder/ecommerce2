<style>
    @media (max-width: 576px) {
        li.breadcrumb-item:last-child {
            padding-left: 0px;
        }
    }

    .if-time-running-out {
        margin-top: 200px;
    }

    @media only screen and (max-width: 767px) {
        .if-time-running-out {
            margin-top: 400px;
        }
    }
</style>
<div class="breadcrumb-header justify-content-center my-2">
    <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
            @if (config('shortcutManu')->count() > 0)
                <ol class="breadcrumb text-center">
                    @foreach (config('shortcutManu') as $menu)
                        <li class="{{ $loop->last ? 'me-0' : 'me-2' }}">
                            <a href="{{ $menu->address }}" class="btn mb-2" style="background-color: {{ $menu->bg_color }}; color: {{ $menu->text_color }}; border-radius: 5px; padding: 5px 10px;">
                                @if ($menu->icon != null)
                                    <i class="{{ $menu->icon }} d-inline me-1" style="color: {{ $menu->text_color ?? 'white' }} !important;"></i>
                                @elseif ($menu->img != null)
                                    <img style="width: 20px; margin-top: -2px;" src="{{ asset('storage/shortcut-manu-icon/' . $menu->img) }}" alt="">
                                @else
                                    <i class="fas fa-plus-circle d-inline me-1 " style="color: {{ $menu->text_color ?? 'white' }} !important;"></i>
                                @endif {{ $menu->title }}
                            </a>
                        </li>
                    @endforeach
                </ol>
            @endif
        </nav>
    </div>
</div>
