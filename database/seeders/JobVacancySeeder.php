<?php 

namespace Database\Seeders;

use App\Models\JobVacancy;
use App\Models\SelectionStage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobVacancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hrdUser = User::where('role', 'hrd')->first();
        
        if (!$hrdUser) {
            $this->command->info('No HRD user found. Skipping JobVacancySeeder.');
            return;
        }
        
        // Sample job vacancies
        $jobVacancies = [
            [
                'title' => 'Senior Web Developer',
                'description' => "We are looking for a Senior Web Developer to join our dynamic team. As a Senior Web Developer, you will be responsible for developing and maintaining web applications, ensuring high-performance and availability, and managing all technical aspects of our web projects.\n\nYou will work closely with our design and backend teams to implement new features and ensure responsiveness of applications.",
                'requirements' => "- At least 5 years of experience in web development\n- Strong proficiency in JavaScript, HTML, CSS\n- Experience with React, Vue, or Angular\n- Proficient understanding of server-side CSS preprocessors, such as LESS and SASS\n- Understanding of REST APIs and AJAX\n- Knowledge of performance testing and optimization techniques\n- Adequate knowledge of user authentication and authorization between multiple systems, servers, and environments\n- Understanding of fundamental design principles behind a scalable application\n- Implement security and data protection\n- Create database schemas that represent and support business processes\n- Integration of multiple data sources and databases into one system",
                'responsibilities' => "- Develop new user-facing features\n- Build reusable code and libraries for future use\n- Ensure the technical feasibility of UI/UX designs\n- Optimize application for maximum speed and scalability\n- Assure that all user input is validated before submitting to back-end\n- Collaborate with other team members and stakeholders\n- Maintain code quality, organization, and automatization",
                'location' => 'Yogyakarta',
                'employment_type' => 'full-time',
                'salary_range' => 'Rp 10.000.000 - Rp 15.000.000',
                'department' => 'Engineering',
                'status' => 'active',
                'quota' => 2,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
            ],
            [
                'title' => 'UI/UX Designer',
                'description' => "We are seeking a talented UI/UX Designer to create amazing user experiences. As a UI/UX Designer, you will be responsible for delivering the best online user experiences possible for our customers. You will work with our marketing and development teams to ensure that the designs are engaging, innovative, and user-friendly.\n\nThe ideal candidate should have an eye for clean and artful design, proficiency in standard design tools, and a clear understanding of design principles.",
                'requirements' => "- 3+ years of UI/UX design experience for web and mobile applications\n- Proficiency in design tools such as Adobe XD, Sketch, Figma, Adobe Illustrator, or similar\n- Solid experience in creating wireframes, storyboards, user flows, and process flows\n- Understanding of interaction design and information architecture\n- Knowledge of HTML, CSS, and JavaScript is a plus\n- A strong portfolio of design projects\n- Excellent visual design skills with sensitivity to user-system interaction\n- Ability to present your designs and sell your solutions to various stakeholders\n- Up-to-date with the latest UI/UX trends, techniques, and technologies",
                'responsibilities' => "- Gather and evaluate user requirements in collaboration with product managers and engineers\n- Illustrate design ideas using storyboards, process flows, and sitemaps\n- Design graphic user interface elements, like menus, tabs, and widgets\n- Build page navigation buttons and search fields\n- Develop UI mockups and prototypes that clearly illustrate how sites function and look like\n- Create original graphic designs (e.g. images, sketches, and tables)\n- Prepare and present rough drafts to internal teams and key stakeholders\n- Identify and troubleshoot UX problems (e.g. responsiveness)\n- Conduct layout adjustments based on user feedback\n- Adhere to style standards on fonts, colors, and images",
                'location' => 'Yogyakarta',
                'employment_type' => 'full-time',
                'salary_range' => 'Rp 8.000.000 - Rp 12.000.000',
                'department' => 'Design',
                'status' => 'active',
                'quota' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonths(1),
            ],
            [
                'title' => 'Digital Marketing Specialist',
                'description' => "We are looking for a Digital Marketing Specialist to develop, implement, track and optimize our digital marketing campaigns across all digital channels. You will be responsible for increasing our online presence, website traffic, and lead generation through various digital marketing initiatives.\n\nAs a Digital Marketing Specialist, you should have a strong grasp of current marketing tools and strategies and be able to lead integrated digital marketing campaigns from concept to execution.",
                'requirements' => "- 2+ years of experience in digital marketing\n- Experience with SEO/SEM, Google Analytics, and Google Ads\n- Experience with social media marketing (Facebook, Instagram, Twitter, LinkedIn)\n- Working knowledge of email marketing platforms\n- Understanding of HTML, CSS, and content management systems\n- Excellent writing and communication skills\n- Analytical mindset with ability to interpret data\n- Knowledge of conversion rate optimization\n- Up-to-date with the latest trends and best practices in online marketing and measurement",
                'responsibilities' => "- Plan and execute all digital marketing, including SEO/SEM, marketing database, email, social media and display advertising campaigns\n- Design, build and maintain our social media presence\n- Measure and report performance of all digital marketing campaigns, and assess against goals (ROI and KPIs)\n- Identify trends and insights, and optimize spend and performance based on the insights\n- Brainstorm new and creative growth strategies\n- Plan, execute, and measure experiments and conversion tests\n- Collaborate with internal teams to create landing pages and optimize user experience\n- Utilize strong analytical ability to evaluate end-to-end customer experience across multiple channels and customer touch points\n- Instrument conversion points and optimize user funnels\n- Evaluate emerging technologies. Provide thought leadership and perspective for adoption where appropriate",
                'location' => 'Remote',
                'employment_type' => 'full-time',
                'salary_range' => 'Rp 7.000.000 - Rp 10.000.000',
                'department' => 'Marketing',
                'status' => 'active',
                'quota' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonths(1)->addDays(15),
            ],
            [
                'title' => 'Backend Developer (Laravel)',
                'description' => "We are looking for a Backend Developer with expertise in Laravel to join our growing development team. As a Backend Developer, you will be responsible for developing and maintaining server-side applications, designing database schemas, and ensuring high performance and responsiveness to requests from the front-end.\n\nYou will work closely with our front-end developers to integrate user-facing elements with server-side logic and collaborate with the design team to improve usability.",
                'requirements' => "- 3+ years of experience with Laravel and PHP\n- Strong knowledge of MySQL or PostgreSQL\n- Experience with RESTful APIs\n- Understanding of the MVC design pattern\n- Familiarity with version control systems (Git)\n- Experience with testing frameworks\n- Understanding of Composer and dependency management\n- Knowledge of security best practices\n- Basic understanding of front-end technologies (HTML, CSS, JavaScript)\n- Experience with cloud services like AWS, GCP, or Azure is a plus\n- Experience with Docker and containerization is a plus",
                'responsibilities' => "- Design, implement, and maintain efficient, reusable, and reliable code\n- Develop backend components to improve performance and functionality\n- Integrate data storage solutions\n- Identify bottlenecks and bugs, and devise solutions to mitigate and address these issues\n- Help maintain code quality, organization, and automatization\n- Write unit tests and participate in code reviews\n- Communicate with external vendors and third-party partners\n- Work with front-end developers to integrate user-facing elements\n- Provide technical guidance and mentorship to junior developers\n- Stay informed about emerging technologies and industry trends",
                'location' => 'Yogyakarta',
                'employment_type' => 'full-time',
                'salary_range' => 'Rp 9.000.000 - Rp 13.000.000',
                'department' => 'Engineering',
                'status' => 'active',
                'quota' => 3,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
            ],
            [
                'title' => 'Mobile App Developer (Flutter)',
                'description' => "We are seeking a talented Mobile App Developer with experience in Flutter to join our development team. As a Flutter Developer, you will be responsible for developing and maintaining mobile applications for both iOS and Android platforms using the Flutter framework.\n\nYou will work with our design and backend teams to create responsive, user-friendly applications that provide a seamless experience across various devices.",
                'requirements' => "- 2+ years of experience with Flutter development\n- Experience with Dart programming language\n- Understanding of the mobile development lifecycle\n- Experience with RESTful APIs and integrating mobile apps with backend services\n- Knowledge of state management solutions (Provider, BLoC, Redux, etc.)\n- Experience with version control systems (Git)\n- Familiarity with native development for iOS or Android is a plus\n- Understanding of design principles and UX/UI fundamentals\n- Knowledge of testing frameworks and writing unit tests\n- Ability to diagnose and fix bugs and performance bottlenecks",
                'responsibilities' => "- Design, build, and maintain high-performance, reliable, and reusable Flutter code\n- Implement new features and maintain existing ones for our mobile applications\n- Ensure the performance, quality, and responsiveness of applications\n- Identify and correct bottlenecks and fix bugs\n- Help maintain code quality, organization, and automatization\n- Collaborate with the design team to implement UI/UX wireframes\n- Work with the backend team to integrate mobile applications with server-side logic\n- Deploy applications to Google Play Store and Apple App Store\n- Stay up-to-date with new mobile technology trends, applications, and protocols\n- Provide technical guidance and mentorship to junior developers",
                'location' => 'Remote',
                'employment_type' => 'full-time',
                'salary_range' => 'Rp 8.000.000 - Rp 12.000.000',
                'department' => 'Engineering',
                'status' => 'active',
                'quota' => 2,
                'start_date' => now(),
                'end_date' => now()->addMonths(1)->addDays(20),
            ],
        ];
        
        foreach ($jobVacancies as $jobData) {
            // Generate a unique slug
            $jobData['slug'] = Str::slug($jobData['title']) . '-' . Str::random(5);
            $jobData['created_by'] = $hrdUser->id;
            
            // Create the job vacancy
            $jobVacancy = JobVacancy::create($jobData);
            
            // Create default selection stages
            $defaultStages = [
                ['name' => 'Document Screening', 'description' => 'Review of application documents including CV and cover letter', 'sequence' => 1],
                ['name' => 'Technical Test', 'description' => 'Assessment of technical skills relevant to the position', 'sequence' => 2],
                ['name' => 'Interview', 'description' => 'Interview with the hiring team to assess fit for the role', 'sequence' => 3],
            ];
            
            foreach ($defaultStages as $stageData) {
                $stageData['job_vacancy_id'] = $jobVacancy->id;
                SelectionStage::create($stageData);
            }
        }
    }
}