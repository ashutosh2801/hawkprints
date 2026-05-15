<?php

use App\Models\HomePageSection;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (HomePageSection::where('key', 'software-development-page')->exists()) {
            return;
        }

        HomePageSection::create([
            'key' => 'software-development-page',
            'title' => 'Software Development Page',
            'description' => 'Full page content for the Software Development services page',
            'is_active' => true,
            'sort_order' => HomePageSection::max('sort_order') + 1,
            'settings' => [
                'hero' => [
                    'badge' => 'Now Accepting New Projects',
                    'heading_1' => 'We Build',
                    'heading_2' => 'Digital Excellence',
                    'subtitle' => 'From sleek web apps to powerful mobile solutions, we craft software that scales your business and delights your users.',
                ],
                'stats' => [
                    ['value' => 50, 'suffix' => '+', 'label' => 'Projects Delivered'],
                    ['value' => 30, 'suffix' => '+', 'label' => 'Happy Clients'],
                    ['value' => 5, 'suffix' => '+', 'label' => 'Years Experience'],
                    ['value' => 98, 'suffix' => '%', 'label' => 'Client Satisfaction'],
                ],
                'services_section' => [
                    'badge' => 'What We Offer',
                    'heading' => 'Full-Cycle Software Development',
                    'subtitle' => 'From concept to launch and beyond — we deliver enterprise-grade solutions tailored to your unique business challenges.',
                ],
                'services' => [
                    ['title' => 'Web Development', 'description' => 'Custom websites, SPAs, dashboards, and enterprise portals built with React, Vue, Laravel, and modern architectures.', 'features' => ['Responsive & accessible', 'API-first architecture']],
                    ['title' => 'Mobile Development', 'description' => 'Native and cross-platform iOS & Android apps using Flutter, React Native, and Swift with flawless UX.', 'features' => ['App Store & Play Store deployment', 'Push notifications & offline']],
                    ['title' => 'UI/UX Design', 'description' => 'Research-driven interfaces that blend beauty with usability. Wireframes, prototypes, and design systems.', 'features' => ['Figma & Adobe XD', 'Usability testing included']],
                    ['title' => 'Custom Software', 'description' => 'Tailored ERP, CRM, inventory, and automation platforms built precisely for your business workflows.', 'features' => ['Role-based access control', 'Third-party integrations']],
                    ['title' => 'Cloud Solutions', 'description' => 'Cloud migration, AWS/Azure/GCP architecture, serverless computing, and DevOps pipeline setup.', 'features' => ['Auto-scaling infrastructure', 'CI/CD pipelines']],
                    ['title' => 'Consulting', 'description' => 'Technical strategy, architecture reviews, code audits, and digital transformation roadmaps.', 'features' => ['Tech stack evaluation', 'Scalability planning']],
                ],
                'showcase_section' => [
                    'badge' => 'Our Work',
                    'heading' => "Solutions We've Built",
                    'subtitle' => 'Real projects, real results — across industries and technologies',
                ],
                'showcase' => [
                    ['title' => 'E-Commerce Platform', 'description' => 'Full-featured online store with inventory management, payment integration, and admin dashboard.'],
                    ['title' => 'Rider App', 'description' => 'Cross-platform mobile app with real-time tracking, push notifications, and offline support.'],
                    ['title' => 'CRM Dashboard', 'description' => 'Comprehensive CRM with pipeline management, analytics, team collaboration, and reporting.'],
                ],
                'process_section' => [
                    'badge' => 'How We Work',
                    'heading' => 'From Idea to Launch',
                    'subtitle' => 'A transparent, collaborative process that keeps you in control at every stage',
                ],
                'process' => [
                    ['title' => 'Discovery', 'description' => 'We dive deep into your vision, goals, and requirements to define the perfect roadmap.'],
                    ['title' => 'Design', 'description' => 'Wireframes, interactive prototypes, and polished visual designs for your approval.'],
                    ['title' => 'Build', 'description' => 'Agile development with weekly demos, transparent progress, and continuous feedback.'],
                    ['title' => 'Launch & Support', 'description' => 'Deployment, performance optimization, and ongoing maintenance & support.'],
                ],
                'why_section' => [
                    'badge' => 'Why Choose Us',
                    'heading' => 'Built Different. Built Better.',
                    'subtitle' => 'What sets our software development apart from the rest',
                ],
                'why' => [
                    ['title' => 'Quality Guaranteed', 'description' => 'Rigorous testing, code reviews, and performance optimization in every project we deliver.'],
                    ['title' => 'On-Time Delivery', 'description' => 'Agile sprints, clear milestones, and regular communication — no surprises.'],
                    ['title' => 'Dedicated Team', 'description' => 'Your dedicated project manager and development team — always a message away.'],
                    ['title' => 'Modern Stack', 'description' => 'Latest technologies and frameworks — your product is built to last and scale.'],
                    ['title' => 'Post-Launch Support', 'description' => "We don't walk away after launch. Ongoing support, maintenance, and iterations included."],
                    ['title' => 'Transparent Pricing', 'description' => 'No hidden fees. Clear quotes, fixed budgets, or hourly — whatever works for you.'],
                ],
                'tech_section' => [
                    'badge' => 'Tech Stack',
                    'heading' => 'Technologies We Master',
                    'subtitle' => 'Modern, battle-tested tools that power startups and enterprises alike',
                ],
                'tech' => [
                    'Frontend' => ['React', 'Vue.js', 'Next.js', 'TypeScript', 'Tailwind CSS', 'Alpine.js'],
                    'Backend & APIs' => ['Laravel', 'Node.js', 'Python', 'PHP', 'REST & GraphQL', 'WebSockets'],
                    'Mobile' => ['Flutter', 'React Native', 'Swift', 'Kotlin'],
                    'DevOps & Cloud' => ['AWS', 'Docker', 'CI/CD', 'Linux', 'Nginx', 'Redis'],
                    'Databases' => ['MySQL', 'PostgreSQL', 'MongoDB', 'SQLite'],
                ],
                'testimonials_section' => [
                    'badge' => 'Testimonials',
                    'heading' => 'What Our Clients Say',
                    'subtitle' => "Don't take our word for it — hear from the businesses we've helped",
                ],
                'testimonials' => [
                    ['name' => 'Sarah Khan', 'role' => 'CEO, TrendMart', 'text' => '"They transformed our outdated website into a powerful e-commerce platform. Sales increased by 40% in the first quarter."', 'rating' => 5, 'initials' => 'SK'],
                    ['name' => 'Mike Reynolds', 'role' => 'COO, QuickShip Logistics', 'text' => '"The mobile app they built for our delivery service was a game-changer. Real-time tracking and flawless performance."', 'rating' => 5, 'initials' => 'MR'],
                    ['name' => 'Amanda Liu', 'role' => 'Product Manager, Finova', 'text' => '"Their UI/UX team redesigned our platform from the ground up. User engagement went up 65% and bounce rate dropped by half."', 'rating' => 5, 'initials' => 'AL'],
                ],
                'cta' => [
                    'heading' => 'Ready to Build Your Dream Software?',
                    'subtitle' => "Let's discuss your project. Free consultation, no obligations, just great ideas.",
                    'button_text' => 'Start Your Project',
                ],
                'contact_section' => [
                    'badge' => 'Get in Touch',
                    'heading' => "Tell Us About Your Project",
                    'subtitle' => "Fill out the form and we'll get back to you within 24 hours with a personalized proposal.",
                ],
            ],
        ]);
    }

    public function down(): void
    {
        HomePageSection::where('key', 'software-development-page')->delete();
    }
};
