<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ gs()->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,container-queries"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: {
                preflight: false,
            }
        }
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #fff5f0 0%, #f0fff4 100%);
        }
    </style>
</head>

<body>
    @php
        $content = \App\Models\Frontend::where('data_keys', 'maintenance.data')->first();
    @endphp

    <div class="tw-min-h-screen tw-flex tw-items-center tw-justify-center tw-px-4 tw-py-12">
        <div class="tw-max-w-3xl tw-w-full tw-text-center">
            {{-- Icon --}}
            <div class="tw-mb-8">
                <div class="tw-w-20 tw-h-20 tw-bg-orange-100 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-6">
                    <i class="las la-tools tw-text-5xl tw-text-orange-500"></i>
                </div>
            </div>

            {{-- Image --}}
            @if(@$content->data_values->image)
            <div class="tw-mb-8">
                <img class="tw-w-full tw-max-w-2xl tw-mx-auto tw-rounded-2xl tw-shadow-lg"
                    src="{{ getImage(getFilePath('maintenance') . '/' . @$content->data_values->image, '660x320') }}"
                    alt="@lang('Maintenance')">
            </div>
            @endif

            {{-- Content --}}
            <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-border tw-border-gray-100 tw-p-8 lg:tw-p-12">
                <div class="tw-prose tw-prose-lg tw-max-w-none tw-mx-auto maintenance-content">
                    @php echo @$content->data_values->description @endphp
                </div>

                {{-- Back to Home Button --}}
                <div class="tw-mt-8">
                    <a href="{{ route('home') }}"
                        class="tw-inline-flex tw-items-center tw-gap-2 tw-bg-gradient-to-r tw-from-orange-500 tw-to-green-600 tw-text-white tw-px-8 tw-py-4 tw-rounded-full tw-font-semibold tw-text-lg hover:tw-shadow-lg tw-transition-all tw-no-underline">
                        <i class="las la-home tw-text-xl"></i>
                        @lang('Retour à l\'accueil')
                    </a>
                </div>
            </div>

            {{-- Footer Note --}}
            <p class="tw-mt-8 tw-text-gray-600 tw-text-sm">
                @lang('Nous nous excusons pour la gêne occasionnée et vous remercions de votre patience.')
            </p>
        </div>
    </div>
</body>

</html>
