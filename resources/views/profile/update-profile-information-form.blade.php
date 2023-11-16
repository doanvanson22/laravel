<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <!-- now, let change the profile page, to update doctor info-->

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Profile Picture') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- wire:model.defer is to defer the input with the livewire property until an action is perforemd, such as save button pressed-->

        <!-- Bio Data -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="bio_data" value="{{ __('Bio Data') }}" />
            <textarea class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="bio_data" wire:model.defer="state.bio_data" placehoder="Bio Data"></textarea>
            <x-input-error for="bio_data" class="mt-2" />
        </div>

        <!-- Experience -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="experience" value="{{ __('Experience') }}" />
            <x-input id="experience" type="number" min="0" max="60" class="mt-1 block w-full" wire:model.defer="state.experience" autocomplete="experience" />
            <x-input-error for="experience" class="mt-2" />
        </div>

        <!-- Category -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="category" value="{{ __('Category') }}" />
            <x-input id="category" type="text" max="60" class="mt-1 block w-full" wire:model.defer="state.category" autocomplete="category" />
            <x-input-error for="category" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <!-- in order to save these data into database
        have to edit to Laravel/Jetstream/http/livewire/updateProfileInformationFrom-->
        <!-- để lưu những dữ liệu này vào cơ sở dữ liệu
        phải chỉnh sửa thành Laravel/Jetstream/http/livewire/updateProfileInformationFrom-->

        <!-- seem like the profile picture is not showing however, the database showed it is saved
            so it might becuse of the url is wrong, let's check .env-->

            <!-- now let's build user registration and login at Flutter App-->
                <!-- bây giờ hãy xây dựng đăng ký người dùng và đăng nhập tại Flutter App-->

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
