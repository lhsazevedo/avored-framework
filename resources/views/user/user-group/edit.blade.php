@extends('avored::layouts.app')

@section('meta_title')
    {{ __('avored::user.user-group.edit.title') }}: AvoRed E commerce Admin Dashboard
@endsection

@section('page_title')
    {{ __('avored::user.user-group.edit.title') }}
@endsection

@section('content')
<a-row type="flex" justify="center">
    <a-col :span="24">
        <user-group-save
            base-url="{{ asset(config('avored.admin_url')) }}"
            :user-group="{{ $userGroup }}" inline-template>
        <div>
            <a-form 
                :form="userGroupForm"
                method="post"
                action="{{ route('admin.user-group.update', $userGroup->id) }}"                    
                @submit="handleSubmit"
            >
                @csrf
                @method('put')
                @include('avored::user.user-group._fields')
                
                <a-form-item>
                    <a-button
                        type="primary"
                        html-type="submit"
                    >
                        {{ __('avored::system.btn.save') }}
                    </a-button>
                    
                    <a-button
                        class="ml-1"
                        type="default"
                        v-on:click.prevent="cancelUserGroup"
                    >
                        {{ __('avored::system.btn.cancel') }}
                    </a-button>
                </a-form-item>
            </a-form>
            </div>
        </user-group-save>
    </a-col>
</a-row>
@endsection
