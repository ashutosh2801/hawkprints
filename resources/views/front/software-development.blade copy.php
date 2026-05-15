@extends('layouts.app')

@section('title', 'Software Development - Five Rivers Print')
@section('meta_description', 'Professional software development services including web development, mobile apps, UI/UX design, and custom software solutions. Transform your ideas into reality.')

@section('content')
<!-- Hero -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900 text-white">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-20 w-96 h-96 bg-blue-400 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-indigo-400 rounded-full filter blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 py-24 relative">
        <div class="max-w-4xl mx-auto text-center">
            <span class="inline-block px-4 py-1.5 bg-white/10 text-white text-sm font-medium rounded-full mb-6 border border-white/20">Software Development</span>
            <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Build <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Amazing Software</span> That Drives Growth</h1>
            <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto leading-relaxed">From web applications to mobile apps, we craft digital solutions that help businesses scale, automate, and succeed in the modern world.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#services" class="px-8 py-3.5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-indigo-600 transition-all shadow-lg shadow-blue-500/25">Explore Services</a>
                <a href="#contact" class="px-8 py-3.5 bg-white/10 text-white rounded-xl font-semibold hover:bg-white/20 transition-all border border-white/20">Get a Quote</a>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<section id="services" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">What We Offer</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Software Development Services</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">End-to-end software development tailored to your business needs</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Web Development</h3>
                <p class="text-gray-600 leading-relaxed">Custom websites, web applications, and portals built with modern frameworks like React, Vue, Laravel, and Node.js.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Mobile Development</h3>
                <p class="text-gray-600 leading-relaxed">Native and cross-platform mobile apps for iOS and Android using Flutter, React Native, and Swift.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">UI/UX Design</h3>
                <p class="text-gray-600 leading-relaxed">User-centered design that combines aesthetics with usability to create seamless digital experiences.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Custom Software</h3>
                <p class="text-gray-600 leading-relaxed">Tailored software solutions including ERP, CRM, inventory management, and business automation tools.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Cloud Solutions</h3>
                <p class="text-gray-600 leading-relaxed">Cloud migration, AWS/Azure/GCP architecture, serverless solutions, and scalable infrastructure setup.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-rose-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Consulting</h3>
                <p class="text-gray-600 leading-relaxed">Technology consulting, architecture review, technical due diligence, and digital transformation strategy.</p>
            </div>
        </div>
    </div>
</section>

<!-- Process -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">How We Work</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Development Process</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">A proven methodology that ensures quality, transparency, and timely delivery</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
            <div class="text-center relative">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-700">1</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Discovery</h3>
                <p class="text-sm text-gray-600">We analyze your requirements and define project scope</p>
            </div>
            <div class="text-center relative">
                <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-indigo-700">2</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Design</h3>
                <p class="text-sm text-gray-600">We create wireframes, prototypes, and visual designs</p>
            </div>
            <div class="text-center relative">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-purple-700">3</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Development</h3>
                <p class="text-sm text-gray-600">Agile sprints with regular updates and demos</p>
            </div>
            <div class="text-center relative">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-green-700">4</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Launch</h3>
                <p class="text-sm text-gray-600">Deployment, testing, and ongoing support</p>
            </div>
        </div>
    </div>
</section>

<!-- Tech Stack -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-700 text-sm font-medium rounded-full mb-4">Technologies</span>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Technologies We Work With</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Modern tools and frameworks to build robust, scalable applications</p>
        </div>
        <div class="flex flex-wrap justify-center gap-4">
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">React</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">Vue.js</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">Laravel</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">Node.js</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">Python</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">Flutter</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">React Native</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">AWS</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">Docker</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">MySQL</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">PostgreSQL</span>
            <span class="px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-gray-700 font-medium">Redis</span>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section id="contact" class="py-20 bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-10 w-80 h-80 bg-blue-400 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-indigo-400 rounded-full filter blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-white/10 text-white text-sm font-medium rounded-full mb-4 border border-white/20">Start Your Project</span>
            <h2 class="text-4xl font-bold mb-4">Let's Build Something Great Together</h2>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">Tell us about your project and we'll get back to you within 24 hours</p>
        </div>

        @if(session('success'))
        <div class="max-w-2xl mx-auto mb-8 p-4 bg-green-500/20 border border-green-400/30 text-green-200 rounded-xl">
            {{ session('success') }}
        </div>
        @endif

        <div class="max-w-2xl mx-auto">
            <form action="{{ route('software.development.submit') }}" method="POST" class="bg-white/5 backdrop-blur-sm rounded-2xl p-8 md:p-12 border border-white/10">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-blue-200 mb-2">Full Name *</label>
                        <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('name') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-200 mb-2">Email Address *</label>
                        <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('email') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-200 mb-2">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('phone') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-200 mb-2">Company</label>
                        <input type="text" name="company" value="{{ old('company') }}" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('company') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-200 mb-2">Service Needed *</label>
                        <select name="service" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="" class="text-gray-800">Select a service</option>
                            <option value="web_development" class="text-gray-800" {{ old('service') == 'web_development' ? 'selected' : '' }}>Web Development</option>
                            <option value="mobile_development" class="text-gray-800" {{ old('service') == 'mobile_development' ? 'selected' : '' }}>Mobile Development</option>
                            <option value="ux_ui_design" class="text-gray-800" {{ old('service') == 'ux_ui_design' ? 'selected' : '' }}>UI/UX Design</option>
                            <option value="custom_software" class="text-gray-800" {{ old('service') == 'custom_software' ? 'selected' : '' }}>Custom Software</option>
                            <option value="cloud_solutions" class="text-gray-800" {{ old('service') == 'cloud_solutions' ? 'selected' : '' }}>Cloud Solutions</option>
                            <option value="consulting" class="text-gray-800" {{ old('service') == 'consulting' ? 'selected' : '' }}>Consulting</option>
                            <option value="other" class="text-gray-800" {{ old('service') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('service') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-200 mb-2">Budget (CAD)</label>
                        <input type="number" name="budget" step="0.01" min="0" value="{{ old('budget') }}" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('budget') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-blue-200 mb-2">Project Details *</label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-300/50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-8">
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-semibold hover:from-blue-600 hover:to-indigo-600 transition-all shadow-lg shadow-blue-500/25">
                        Send Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
