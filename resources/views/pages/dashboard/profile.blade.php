@extends('layouts.app')

@section('title', 'Profil')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profil</h1>
                <div class="section-header-breadcrumb">
                    <x-partials.elements.buttons.back :href="url()->previous()" />
                </div>
            </div>
            @include('components.partials.alerts.list-error')
            @include('components.partials.alerts.session')
            <div class="section-body">
                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <form method="POST" action="{{ route('dashboard.profile.update') }}">
                                @csrf
                                @method('POST')
                                <div class="card-header">
                                    <h4>Profil</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <x-partials.elements.list-group.item label="Nama" :value="auth()->user()->name" />
                                        <x-partials.elements.list-group.item label="Nama Pengguna" :value="auth()->user()->username" />
                                    </ul>
                                    <div id="profileForm" style="display: none;">
                                        <div class="row mt-3">
                                            <div class="col-md-6 col-12">
                                                <x-partials.elements.form-group.input label="Nama" name="name"
                                                    :value="auth()->user()->name" required="true" />
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <x-partials.elements.form-group.input label="Nama Pengguna" name="username"
                                                    :value="auth()->user()->username" required="true" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <x-partials.elements.form-group.input label="Kata Sandi Lama"
                                                    name="current_password" type="password" value="" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-partials.elements.form-group.input label="Kata Sandi Baru"
                                                    name="new_password" type="password" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="button" id="changeProfileBtn" class="btn btn-primary">Ganti
                                        Profil</button>
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changeProfileBtn = document.getElementById('changeProfileBtn');
            const profileForm = document.getElementById('profileForm');
            const updateBtn = document.querySelector('button[type="submit"]');
            const initialInfo = document.querySelector('.card-body > .list-group');
            const cardFooter = document.querySelector('.card-footer');

            updateBtn.style.display = 'none';
            cardFooter.style.textAlign = 'right';

            changeProfileBtn.addEventListener('click', function() {
                profileForm.style.display = 'block';
                changeProfileBtn.style.display = 'none';
                updateBtn.style.display = 'inline-block';
                initialInfo.style.display = 'none';
            });

            // Check if there are validation errors
            const hasErrors = document.querySelector('.alert-danger');
            if (hasErrors) {
                profileForm.style.display = 'block';
                changeProfileBtn.style.display = 'none';
                updateBtn.style.display = 'inline-block';
                initialInfo.style.display = 'none';
            }
        });
    </script>
    <!-- Page Specific JS File -->
@endpush
