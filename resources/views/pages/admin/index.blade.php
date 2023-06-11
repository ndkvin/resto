@extends('layouts.admin')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="page-description text-center">
                <h1>Pricing Tables</h1>
                <span>Elegant, responsive and simple pricing tables.</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 col-sm-offset-2 col-sm-10 col-lg-offset-2 col-lg-10 mx-auto">
            <div class="row">
                <div class="col-12 col-xl-4">
                    <div class="card pricing-basic">
                        <div class="card-body">
                            <h3 class="plan-title">Standard</h3>
                            <div class="plan-price">
                                <span class="plan-price-value">$49</span>
                                <span class="plan-price-period">/ month</span>
                            </div>
                            <span class="plan-description">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit.</span>
                            <ul class="plan-list">
                                <li>Up to 10 Devices</li>
                                <li>250GB of SSD Storage</li>
                                <li>500GB Monthly Bandwidth</li>
                                <li>50 Email Accounts</li>
                                <li>30 Form Submissions</li>
                                <li>24/7 Online Support</li>
                            </ul>
                            <div class="m-t-md d-grid">
                                <button class="btn btn-secondary btn-lg" type="button">Buy
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="card pricing-basic pricing-selected">
                        <div class="card-body">
                            <h3 class="plan-title">Premium<span class="badge badge-info badge-style-light">Popular</span>
                            </h3>
                            <div class="plan-price">
                                <span class="plan-price-value">$79</span>
                                <span class="plan-price-period">/ month</span>
                            </div>
                            <span class="plan-description">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit.</span>
                            <ul class="plan-list">
                                <li>Up to 50 Devices</li>
                                <li>500GB of SSD Storage</li>
                                <li>Unlimited Monthly Bandwidth</li>
                                <li>100 Email Accounts</li>
                                <li>300 Form Submissions</li>
                                <li>24/7 Online Support</li>
                            </ul>
                            <div class="m-t-md d-grid">
                                <button class="btn btn-primary btn-lg" type="button">Buy
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="card pricing-basic">
                        <div class="card-body">
                            <h3 class="plan-title">Enterprise</h3>
                            <div class="plan-price">
                                <span class="plan-price-value">$149</span>
                                <span class="plan-price-period">/ month</span>
                            </div>
                            <span class="plan-description">Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit.</span>
                            <ul class="plan-list">
                                <li>Unlimited Devices</li>
                                <li>5TB of SSD Storage</li>
                                <li>Unlimited Monthly Bandwidth</li>
                                <li>Unlimited Email Accounts</li>
                                <li>Unlimited Form Submissions</li>
                                <li>Private Support</li>
                            </ul>
                            <div class="m-t-md d-grid">
                                <button class="btn btn-secondary btn-lg" type="button">Buy
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
