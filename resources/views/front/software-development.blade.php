@extends('layouts.app')

@section('title', 'Software Development - Five Rivers Print')
@section('meta_description', 'Professional software development services including web development, mobile apps, UI/UX design, and custom software solutions. Transform your ideas into reality.')

@push('styles')
<style>
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    .reveal-scale {
        opacity: 0;
        transform: scale(0.9);
        transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .reveal-scale.revealed {
        opacity: 1;
        transform: scale(1);
    }
    .reveal-delay-1 { transition-delay: 0.1s; }
    .reveal-delay-2 { transition-delay: 0.2s; }
    .reveal-delay-3 { transition-delay: 0.3s; }
    .reveal-delay-4 { transition-delay: 0.4s; }
    .reveal-delay-5 { transition-delay: 0.5s; }
    .reveal-delay-6 { transition-delay: 0.6s; }

    .gradient-text {
        background: linear-gradient(135deg, #60a5fa, #818cf8, #c084fc, #60a5fa);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmerText 4s ease infinite;
    }
    @keyframes shimmerText {
        0%, 100% { background-position: 0% center; }
        50% { background-position: 100% center; }
    }

    .hero-gradient-mesh {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 80% 50% at 0% 50%, rgba(59,130,246,0.15) 0%, transparent 100%),
            radial-gradient(ellipse 80% 50% at 100% 50%, rgba(139,92,246,0.15) 0%, transparent 100%),
            radial-gradient(ellipse 50% 50% at 50% 0%, rgba(99,102,241,0.1) 0%, transparent 100%),
            radial-gradient(ellipse 50% 50% at 50% 100%, rgba(34,211,238,0.08) 0%, transparent 100%);
        animation: meshShift 12s ease-in-out infinite alternate;
    }
    @keyframes meshShift {
        0% { transform: scale(1) rotate(0deg); }
        100% { transform: scale(1.1) rotate(2deg); }
    }

    .hero-particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255,255,255,0.4);
        border-radius: 50%;
        animation: particleFloat 20s infinite linear;
    }
    @keyframes particleFloat {
        0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateY(-10vh) rotate(720deg); opacity: 0; }
    }

    .typewriter-cursor::after {
        content: '|';
        animation: blink 1s step-end infinite;
        color: #60a5fa;
        font-weight: 300;
    }
    @keyframes blink {
        50% { opacity: 0; }
    }

    .stat-card {
        position: relative;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .stat-card:hover {
        transform: translateY(-4px);
    }
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 60%;
        height: 3px;
        background: linear-gradient(90deg, #60a5fa, #818cf8);
        border-radius: 2px;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .stat-card:hover::after {
        transform: translateX(-50%) scaleX(1);
    }

    .service-card {
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }
    .service-card:hover {
        transform: translateY(-12px) scale(1.02);
    }
    .service-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background: linear-gradient(135deg, var(--card-glow, transparent), transparent);
        opacity: 0;
        transition: opacity 0.6s ease;
    }
    .service-card:hover::before {
        opacity: 1;
    }
    .service-card .icon-wrap {
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .service-card:hover .icon-wrap {
        transform: scale(1.15) rotate(-5deg);
        border-radius: 18px;
    }

    .testimonial-card {
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .testimonial-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 48px -16px rgba(0, 0, 0, 0.15);
    }
    .testimonial-card .quote-mark {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        font-size: 5rem;
        line-height: 1;
        opacity: 0.08;
        font-family: Georgia, serif;
        color: var(--quote-color, #3b82f6);
    }

    .why-icon {
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .why-item:hover .why-icon {
        transform: scale(1.15) rotate(-8deg);
        border-radius: 14px;
    }

    .showcase-card {
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }
    .showcase-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 48px -16px rgba(0, 0, 0, 0.15);
    }

    .cta-glow {
        animation: ctaPulse 3s ease-in-out infinite;
    }
    @keyframes ctaPulse {
        0%, 100% { box-shadow: 0 0 20px rgba(59,130,246,0.3), 0 0 40px rgba(99,102,241,0.1); }
        50% { box-shadow: 0 0 30px rgba(59,130,246,0.5), 0 0 60px rgba(99,102,241,0.2); }
    }

    .floating-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.12;
        animation: floatShape 10s ease-in-out infinite;
    }
    @keyframes floatShape {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(40px, -40px) scale(1.15); }
        50% { transform: translate(-20px, 20px) scale(0.9); }
        75% { transform: translate(20px, 40px) scale(1.05); }
    }
    .floating-shape:nth-child(2) { animation-delay: -3.33s; }
    .floating-shape:nth-child(3) { animation-delay: -6.66s; }

    .shimmer-btn {
        background-size: 200% auto;
        animation: shimmer 3s linear infinite;
    }
    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    .section-divider {
        height: 6px;
        background: linear-gradient(90deg, transparent, rgba(59,130,246,0.3), rgba(99,102,241,0.3), transparent);
        margin-top: -3px;
    }

    .section-block {
        position: relative;
    }
    .section-block::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 8%;
        right: 8%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(59,130,246,0.15) 20%, rgba(99,102,241,0.15) 50%, rgba(59,130,246,0.15) 80%, transparent);
        pointer-events: none;
    }
    .section-block:last-child::after {
        display: none;
    }

    .form-input-enhanced {
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .form-input-enhanced:focus {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px -8px rgba(59,130,246,0.2);
    }

    .btn-primary {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }
    .btn-primary::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .btn-primary:hover::before {
        opacity: 1;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 32px -8px rgba(59,130,246,0.4);
    }

    @media (prefers-reduced-motion: reduce) {
        .reveal, .reveal-scale, .floating-shape, .shimmer-btn,
        .gradient-text, .hero-gradient-mesh, .hero-particle, .cta-glow {
            animation: none !important;
            transition: none !important;
        }
        .reveal, .reveal-scale { opacity: 1; transform: none; }
    }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-[#0b1120] to-indigo-950 text-white min-h-[90vh] flex items-center section-block">
    <div class="hero-gradient-mesh"></div>
    <div class="floating-shape w-[600px] h-[600px] bg-blue-500 -top-32 -left-32"></div>
    <div class="floating-shape w-[500px] h-[500px] bg-indigo-500 top-1/3 -right-24"></div>
    <div class="floating-shape w-[400px] h-[400px] bg-purple-500 bottom-10 left-1/4"></div>

    <div class="absolute inset-0 opacity-[0.025]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 36px 36px;"></div>

    @for($p = 0; $p < 20; $p++)
    <div class="hero-particle" style="left: {{ rand(0, 100) }}%; animation-delay: -{{ rand(0, 20) }}s; animation-duration: {{ 15 + rand(0, 15) }}s; width: {{ 2 + rand(0, 4) }}px; height: {{ 2 + rand(0, 4) }}px;"></div>
    @endfor

    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-5xl mx-auto">
            <div class="text-center md:text-left md:flex md:items-center md:gap-20">
                <div class="md:w-3/5">
                    <span class="inline-block px-5 py-1.5 bg-white/[0.07] text-blue-200 text-sm font-medium rounded-full mb-6 border border-white/[0.08] backdrop-blur-md reveal revealed">
                        <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                        Now Accepting New Projects
                    </span>
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-[1.08] reveal revealed">
                        We Build
                        <br>
                        <span class="gradient-text typewriter-cursor">Digital Excellence</span>
                    </h1>
                    <p class="text-lg md:text-xl text-blue-100/70 mb-10 max-w-xl leading-relaxed reveal revealed reveal-delay-1">
                        From sleek web apps to powerful mobile solutions, we craft software that scales your business and delights your users.
                    </p>
                    <div class="flex flex-wrap gap-4 reveal revealed reveal-delay-2">
                        <a href="#services" class="btn-primary group px-8 py-3.5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-semibold shadow-lg shadow-blue-500/25 inline-flex items-center gap-2">
                            Explore Services
                            <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="#contact" class="px-8 py-3.5 bg-white/[0.04] text-white rounded-xl font-semibold hover:bg-white/[0.08] transition-all duration-300 border border-white/[0.08] hover:border-white/[0.15] backdrop-blur-md">
                            Start a Project
                        </a>
                    </div>
                </div>
                <div class="hidden md:block md:w-2/5 reveal revealed reveal-delay-3">
                    <div class="relative perspective-[1000px]">
                        <div class="w-72 h-72 mx-auto relative" style="transform: rotateY(-8deg) rotateX(5deg); transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);" onmouseenter="this.style.transform='rotateY(0deg) rotateX(0deg)'" onmouseleave="this.style.transform='rotateY(-8deg) rotateX(5deg)'">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-indigo-500/20 rounded-3xl rotate-6"></div>
                            <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/10 to-indigo-600/10 rounded-3xl -rotate-3 backdrop-blur-sm border border-white/10"></div>
                            <div class="absolute inset-4 bg-gradient-to-br from-gray-800/40 to-gray-900/50 rounded-2xl backdrop-blur-sm border border-white/10 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="mb-4">
                                        <svg class="w-20 h-20 mx-auto text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2 justify-center text-sm text-blue-200">
                                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                            <span><span class="font-semibold text-white">5+</span> Years Experience</span>
                                        </div>
                                        <div class="flex items-center gap-2 justify-center text-sm text-blue-200">
                                            <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.5s"></span>
                                            <span><span class="font-semibold text-white">50+</span> Projects Delivered</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="relative -mt-16 z-20 section-block">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-[0_12px_48px_-12px_rgba(0,0,0,0.2)] grid grid-cols-2 md:grid-cols-4 overflow-hidden border border-gray-100/50">
            @php
                $statData = [
                    ['value' => 50, 'suffix' => '+', 'label' => 'Projects Delivered'],
                    ['value' => 5, 'suffix' => '+', 'label' => 'Years Experience'],
                    ['value' => 30, 'suffix' => '+', 'label' => 'Happy Clients'],
                    ['value' => 98, 'suffix' => '%', 'label' => 'Client Satisfaction'],
                ];
            @endphp
            @foreach($statData as $i => $stat)
            <div class="stat-card p-6 md:p-8 text-center reveal{{ $i > 0 ? ' reveal-delay-' . $i : '' }} border-r border-gray-100 last:border-r-0">
                <div class="text-3xl md:text-4xl font-bold gradient-text mb-1">
                    <span class="stat-counter" data-target="{{ $stat['value'] }}">0</span>{{ $stat['suffix'] }}
                </div>
                <div class="text-sm text-gray-500 font-medium tracking-wide">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="section-divider"></div>

<!-- Services -->
<section id="services" class="py-24 bg-gray-50 relative section-block">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <span class="inline-block px-5 py-1.5 bg-blue-100/60 text-blue-700 text-sm font-semibold rounded-full mb-4 reveal backdrop-blur-sm border border-blue-200/50">What We Offer</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 reveal reveal-delay-1 leading-[1.1]">Full-Cycle Software Development</h2>
            <p class="text-lg text-gray-500 reveal reveal-delay-2 max-w-2xl mx-auto">From concept to launch and beyond — we deliver exceptional software solutions</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $services = [
                    ['title' => 'Web Development', 'description' => 'Custom websites, web applications, and portals built with modern frameworks like React, Vue, Laravel, and Node.js.',
                     'features' => ['Single-page & Progressive Web Apps', 'E-commerce & Marketplaces', 'Custom CMS & Portals', 'API Development & Integration'],
                     'icon' => 0],
                    ['title' => 'Mobile Development', 'description' => 'Native and cross-platform mobile apps for iOS and Android using Flutter, React Native, and Swift.',
                     'features' => ['iOS & Android Native Apps', 'Cross-platform Solutions', 'App Store Optimization', 'Real-time & Offline Apps'],
                     'icon' => 1],
                    ['title' => 'UI/UX Design', 'description' => 'User-centered design that combines aesthetics with usability to create seamless digital experiences.',
                     'features' => ['User Research & Testing', 'Wireframing & Prototyping', 'Visual Design & Branding', 'Design Systems'],
                     'icon' => 2],
                    ['title' => 'Custom Software', 'description' => 'Tailored software solutions including ERP, CRM, inventory management, and business automation tools.',
                     'features' => ['ERP & CRM Systems', 'Business Automation', 'Data Analytics Dashboards', 'Legacy System Modernization'],
                     'icon' => 3],
                    ['title' => 'Cloud Solutions', 'description' => 'Cloud migration, AWS/Azure/GCP architecture, serverless solutions, and scalable infrastructure setup.',
                     'features' => ['Cloud Migration & Strategy', 'Serverless Architecture', 'DevOps & CI/CD', 'Scalable Infrastructure'],
                     'icon' => 4],
                    ['title' => 'Consulting', 'description' => 'Technology consulting, architecture review, technical due diligence, and digital transformation strategy.',
                     'features' => ['Tech Stack Advisory', 'Architecture Review', 'Security Audit', 'Digital Transformation'],
                     'icon' => 5],
                ];
                $colorMap = ['#3b82f6', '#22c55e', '#a855f7', '#f97316', '#06b6d4', '#f43f5e'];
                $gradFrom = ['from-blue-500', 'from-green-500', 'from-purple-500', 'from-orange-500', 'from-cyan-500', 'from-rose-500'];
                $gradTo = ['to-blue-600', 'to-green-600', 'to-purple-600', 'to-orange-600', 'to-cyan-600', 'to-rose-600'];
                $hoverColors = ['group-hover:text-blue-600', 'group-hover:text-green-600', 'group-hover:text-purple-600', 'group-hover:text-orange-600', 'group-hover:text-cyan-600', 'group-hover:text-rose-600'];
                $shadowColors = ['shadow-blue-500/20', 'shadow-green-500/20', 'shadow-purple-500/20', 'shadow-orange-500/20', 'shadow-cyan-500/20', 'shadow-rose-500/20'];
                $icons = [
                    '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>',
                    '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                    '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>',
                    '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>',
                    '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                    '<svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
                ];
                $rgbMap = ['59,130,246', '34,197,94', '168,85,247', '249,115,22', '6,182,212', '244,63,94'];
            @endphp
            @foreach($services as $si => $service)
            <div class="service-card bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl border border-gray-100/80 group" style="--card-glow: rgba({{ $rgbMap[$si % 6] }},0.1)">
                <div class="icon-wrap w-14 h-14 bg-gradient-to-br {{ $gradFrom[$si % 6] }} {{ $gradTo[$si % 6] }} rounded-2xl flex items-center justify-center mb-6 shadow-lg {{ $shadowColors[$si % 6] }}">
                    {!! $icons[$si % 6] !!}
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 {{ $hoverColors[$si % 6] }} transition-colors duration-300">{{ $service['title'] }}</h3>
                <p class="text-gray-500 leading-relaxed mb-5 text-sm">{{ $service['description'] }}</p>
                @if(!empty($service['features']))
                <ul class="space-y-2.5 text-sm text-gray-400">
                    @foreach($service['features'] as $feature)
                    <li class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Work Showcase -->
<section id="work" class="py-24 bg-white relative section-block">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <span class="inline-block px-5 py-1.5 bg-indigo-100/60 text-indigo-700 text-sm font-semibold rounded-full mb-4 reveal backdrop-blur-sm border border-indigo-200/50">Our Work</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 reveal reveal-delay-1 leading-[1.1]">Solutions We've Built</h2>
            <p class="text-lg text-gray-500 reveal reveal-delay-2">Real projects, real results</p>
        </div>
        @php
            $showcase = [
                ['title' => 'E-Commerce Platform', 'description' => 'A high-performance online marketplace handling 10K+ daily transactions with real-time inventory management.'],
                ['title' => 'Healthcare App', 'description' => 'HIPAA-compliant patient management system with telemedicine integration and secure data handling.'],
                ['title' => 'FinTech Dashboard', 'description' => 'Real-time financial analytics platform processing millions of data points with interactive visualizations.'],
            ];
            $showcaseGrads = [
                ['from-blue-50', 'to-indigo-50', 'border-blue-100/50'],
                ['from-green-50', 'to-emerald-50', 'border-green-100/50'],
                ['from-purple-50', 'to-pink-50', 'border-purple-100/50'],
            ];
            $showcaseIcons = [
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
                '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
            ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach($showcase as $shi => $show)
            <div class="group reveal{{ $shi > 0 ? ' reveal-delay-' . $shi : '' }}">
                <div class="showcase-card bg-gradient-to-br {{ $showcaseGrads[$shi % 3][0] }} {{ $showcaseGrads[$shi % 3][1] }} rounded-2xl p-8 border {{ $showcaseGrads[$shi % 3][2] }}">
                    <div class="w-12 h-12 {{ ['bg-blue-100', 'bg-green-100', 'bg-purple-100'][$shi % 3] }} rounded-xl flex items-center justify-center mb-4 {{ ['text-blue-600', 'text-green-600', 'text-purple-600'][$shi % 3] }} shadow-sm">
                        {!! $showcaseIcons[$shi % 3] !!}
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">{{ $show['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $show['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Why Choose Us -->
<section class="py-24 bg-gradient-to-b from-white to-gray-50 relative section-block">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <span class="inline-block px-5 py-1.5 bg-cyan-100/60 text-cyan-700 text-sm font-semibold rounded-full mb-4 reveal backdrop-blur-sm border border-cyan-200/50">Why Choose Us</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 reveal reveal-delay-1 leading-[1.1]">Built Different. Built Better.</h2>
            <p class="text-lg text-gray-500 reveal reveal-delay-2">What sets our software development apart from the rest</p>
        </div>
        @php
            $whyItems = [
                ['title' => 'Agile Methodology', 'description' => '2-week sprints, daily standups, and continuous delivery ensure transparency and rapid iteration.'],
                ['title' => 'Quality First', 'description' => 'Automated testing, code reviews, and CI/CD pipelines ensure production-ready code every time.'],
                ['title' => 'Full-Stack Expertise', 'description' => 'From databases to DevOps, our team covers the entire technology stack in-house.'],
                ['title' => 'Dedicated Support', 'description' => 'Post-launch support with SLAs, monitoring, and 24/7 availability for critical issues.'],
                ['title' => 'Transparent Pricing', 'description' => 'No hidden fees, clear milestones, and flexible engagement models to fit your budget.'],
                ['title' => 'Scalable Solutions', 'description' => 'Architecture designed for growth — from MVP to enterprise scale without rewrites.'],
            ];
            $whyColors = [
                ['bg-blue-100', 'text-blue-600'],
                ['bg-green-100', 'text-green-600'],
                ['bg-purple-100', 'text-purple-600'],
                ['bg-orange-100', 'text-orange-600'],
                ['bg-cyan-100', 'text-cyan-600'],
                ['bg-rose-100', 'text-rose-600'],
            ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach($whyItems as $wi => $why)
            <div class="why-item flex gap-5 reveal{{ $wi > 0 ? ' reveal-delay-' . $wi : '' }} p-5 rounded-2xl hover:bg-white transition-all duration-300 hover:shadow-lg">
                <div class="why-icon w-12 h-12 {{ $whyColors[$wi % 6][0] }} rounded-xl flex items-center justify-center shrink-0 {{ $whyColors[$wi % 6][1] }} shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-gray-900 mb-1.5 text-lg">{{ $why['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $why['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Tech Stack -->
<section class="py-24 bg-gray-50 relative section-block">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <span class="inline-block px-5 py-1.5 bg-indigo-100/60 text-indigo-700 text-sm font-semibold rounded-full mb-4 reveal backdrop-blur-sm border border-indigo-200/50">Tech Stack</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 reveal reveal-delay-1 leading-[1.1]">Technologies We Master</h2>
            <p class="text-lg text-gray-500 reveal reveal-delay-2">Modern, battle-tested tools we use to deliver excellence</p>
        </div>
        @php
            $techCategories = [
                'Frontend' => ['React', 'Vue.js', 'Next.js', 'TypeScript', 'Tailwind CSS', 'Alpine.js'],
                'Backend & APIs' => ['Laravel', 'Node.js', 'Python', 'GraphQL', 'REST APIs', 'Express'],
                'Mobile' => ['Flutter', 'React Native', 'Swift', 'Kotlin', 'Ionic'],
                'DevOps & Cloud' => ['AWS', 'Docker', 'Kubernetes', 'CI/CD', 'Terraform', 'Linux'],
                'Databases' => ['PostgreSQL', 'MySQL', 'MongoDB', 'Redis', 'Elasticsearch'],
            ];
            $categoryStyles = [
                'Frontend' => ['from' => 'from-blue-500', 'to' => 'to-blue-600', 'light' => 'bg-blue-50', 'border' => 'border-blue-200', 'dot' => 'bg-blue-500'],
                'Backend & APIs' => ['from' => 'from-emerald-500', 'to' => 'to-emerald-600', 'light' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500'],
                'Mobile' => ['from' => 'from-purple-500', 'to' => 'to-purple-600', 'light' => 'bg-purple-50', 'border' => 'border-purple-200', 'dot' => 'bg-purple-500'],
                'DevOps & Cloud' => ['from' => 'from-amber-500', 'to' => 'to-amber-600', 'light' => 'bg-amber-50', 'border' => 'border-amber-200', 'dot' => 'bg-amber-500'],
                'Databases' => ['from' => 'from-rose-500', 'to' => 'to-rose-600', 'light' => 'bg-rose-50', 'border' => 'border-rose-200', 'dot' => 'bg-rose-500'],
            ];
        @endphp
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($techCategories as $category => $items)
                @php $cs = $categoryStyles[$category]; @endphp
                <div class="group rounded-2xl {{ $cs['light'] }} border {{ $cs['border'] }} p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 reveal{{ $loop->index > 0 ? ' reveal-delay-' . ($loop->index * 1) : '' }}">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br {{ $cs['from'] }} {{ $cs['to'] }} flex items-center justify-center text-white text-xs font-bold shadow-sm">{{ substr($category, 0, 2) }}</div>
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">{{ $category }}</h3>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($items as $tech)
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white rounded-lg border border-gray-100 text-gray-600 text-sm font-medium shadow-xs hover:shadow-md hover:border-gray-200 transition-all duration-200">
                                <span class="w-1.5 h-1.5 rounded-full {{ $cs['dot'] }}"></span>
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-24 bg-white relative overflow-hidden section-block">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <span class="inline-block px-5 py-1.5 bg-green-100/60 text-green-700 text-sm font-semibold rounded-full mb-4 reveal backdrop-blur-sm border border-green-200/50">Testimonials</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 reveal reveal-delay-1 leading-[1.1]">What Our Clients Say</h2>
            <p class="text-lg text-gray-500 reveal reveal-delay-2">Don't take our word for it — hear from our clients</p>
        </div>
        @php
            $testimonials = [
                ['name' => 'Sarah Johnson', 'role' => 'CEO, TechStart Inc.', 'text' => 'Five Rivers Print transformed our outdated platform into a modern, scalable solution. Our user engagement increased by 240% within the first quarter.',
                 'rating' => 5, 'initials' => 'SJ', 'quoteColor' => '#3b82f6', 'gradFrom' => 'from-blue-500', 'gradTo' => 'to-blue-600'],
                ['name' => 'Michael Chen', 'role' => 'CTO, HealthBridge', 'text' => 'The team\'s expertise in healthcare compliance and modern architecture was impressive. They delivered a HIPAA-compliant platform ahead of schedule.',
                 'rating' => 5, 'initials' => 'MC', 'quoteColor' => '#22c55e', 'gradFrom' => 'from-green-500', 'gradTo' => 'to-green-600'],
                ['name' => 'Emily Rodriguez', 'role' => 'Founder, Bloom Retail', 'text' => 'Our e-commerce platform handles 10x the traffic it was built for, thanks to their scalable architecture. Truly a game-changing partnership.',
                 'rating' => 5, 'initials' => 'ER', 'quoteColor' => '#a855f7', 'gradFrom' => 'from-purple-500', 'gradTo' => 'to-purple-600'],
            ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach($testimonials as $ti => $tst)
            <div class="testimonial-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100/80 reveal{{ $ti > 0 ? ' reveal-delay-' . $ti : '' }}" style="--quote-color: {{ $tst['quoteColor'] }}">
                <div class="quote-mark">"</div>
                <div class="flex gap-1 mb-4">
                    @for($s = 0; $s < $tst['rating']; $s++)
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-500 text-sm leading-relaxed mb-6 relative z-10 italic">{{ $tst['text'] }}</p>
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <div class="w-11 h-11 bg-gradient-to-br {{ $tst['gradFrom'] }} {{ $tst['gradTo'] }} rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md">{{ $tst['initials'] }}</div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $tst['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $tst['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 bg-gradient-to-br from-gray-900 via-[#0b1120] to-indigo-950 text-white relative overflow-hidden section-block">
    <div class="container mx-auto px-4 relative">
        <div class="max-w-3xl mx-auto text-center reveal-scale">
            <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-[1.1]">Ready to Build Your Dream Software?</h2>
            <p class="text-lg text-blue-200/60 mb-10 max-w-2xl mx-auto">Let's discuss your project. Free consultation, no obligations, just great ideas.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#contact" class="btn-primary cta-glow px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-semibold shadow-lg shadow-blue-500/25 inline-flex items-center gap-2 text-lg">
                    Start Your Project
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="mailto:fiveriversprint@gmail.com" class="px-8 py-4 bg-white/[0.04] text-white rounded-xl font-semibold hover:bg-white/[0.08] transition-all duration-300 border border-white/[0.08] hover:border-white/[0.15] backdrop-blur-md inline-flex items-center gap-2 text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Email Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section id="contact" class="py-24 bg-gradient-to-b from-gray-50 to-white relative section-block">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <span class="inline-block px-5 py-1.5 bg-blue-100/60 text-blue-700 text-sm font-semibold rounded-full mb-4 reveal backdrop-blur-sm border border-blue-200/50">Get in Touch</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 reveal reveal-delay-1 leading-[1.1]">Tell Us About Your Project</h2>
                <p class="text-lg text-gray-500 reveal reveal-delay-2 max-w-2xl mx-auto">Fill out the form and we'll get back to you within 24 hours with a personalized proposal.</p>
            </div>

            @if(session('success'))
            <div class="mb-8 p-6 bg-green-50 border border-green-200/80 text-green-800 rounded-2xl reveal shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-green-800">Thank You!</p>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-3xl shadow-[0_12px_48px_-12px_rgba(0,0,0,0.15)] p-8 md:p-12 border border-gray-100/50 reveal reveal-delay-3">
                <form action="{{ route('software.development.submit') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required value="{{ old('name') }}" class="form-input-enhanced w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required value="{{ old('email') }}" class="form-input-enhanced w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="form-input-enhanced w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Company</label>
                            <input type="text" name="company" value="{{ old('company') }}" class="form-input-enhanced w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            @error('company') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Service Needed <span class="text-red-500">*</span></label>
                            <select name="service" required class="form-input-enhanced w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option value="" disabled {{ old('service') ? '' : 'selected' }}>Select a service</option>
                                <option value="web_development" {{ old('service') == 'web_development' ? 'selected' : '' }}>Web Development</option>
                                <option value="mobile_development" {{ old('service') == 'mobile_development' ? 'selected' : '' }}>Mobile Development</option>
                                <option value="ux_ui_design" {{ old('service') == 'ux_ui_design' ? 'selected' : '' }}>UI/UX Design</option>
                                <option value="custom_software" {{ old('service') == 'custom_software' ? 'selected' : '' }}>Custom Software</option>
                                <option value="cloud_solutions" {{ old('service') == 'cloud_solutions' ? 'selected' : '' }}>Cloud Solutions</option>
                                <option value="consulting" {{ old('service') == 'consulting' ? 'selected' : '' }}>Consulting</option>
                                <option value="other" {{ old('service') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('service') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Budget (CAD)</label>
                            <input type="number" name="budget" step="0.01" min="0" value="{{ old('budget') }}" class="form-input-enhanced w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="e.g. 5000">
                            @error('budget') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Project Details <span class="text-red-500">*</span></label>
                            <textarea name="message" rows="5" required class="form-input-enhanced w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Tell us about your project, goals, timeline, and any specific requirements...">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="btn-primary w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-lg shadow-blue-600/20 shimmer-btn">
                            <span class="flex items-center justify-center gap-2 text-lg">
                                Send Your Inquiry
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const revealEls = document.querySelectorAll('.reveal, .reveal-scale');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => observer.observe(el));

    const counters = document.querySelectorAll('.stat-counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.dataset.target);
                let current = 0;
                const increment = Math.ceil(target / 60);
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        el.textContent = target;
                        clearInterval(timer);
                    } else {
                        el.textContent = current;
                    }
                }, 25);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });
    counters.forEach(el => counterObserver.observe(el));
});
</script>
@endpush
