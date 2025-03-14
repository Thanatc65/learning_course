<?php
// In a real application, you would fetch this data from a database based on the ID
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Sample course data
$course = [
    'id' => $course_id,
    'title' => 'UX Design Fundamentals',
    'category' => 'Design',
    'difficulty' => 'Beginner',
    'instructor' => [
        'name' => 'Sarah Johnson',
        'image' => '/placeholder.svg?height=150&width=150',
        'bio' => 'Sarah is a senior UX designer with over 10 years of experience working with top tech companies. She specializes in user research, interaction design, and usability testing.',
        'courses' => 12,
        'students' => 15000,
        'rating' => 4.8
    ],
    'rating' => 4.8,
    'students' => 2453,
    'reviews' => 342,
    'image' => '/placeholder.svg?height=400&width=800',
    'price' => 49.99,
    'description' => 'Learn the core principles of user experience design and create intuitive, user-friendly interfaces. This comprehensive course covers everything from user research to prototyping and usability testing.',
    'what_youll_learn' => [
        'Understand the fundamental principles of UX design',
        'Conduct effective user research and create user personas',
        'Design intuitive navigation systems and information architecture',
        'Create wireframes and interactive prototypes',
        'Perform usability testing and iterate on your designs',
        'Apply UX best practices to real-world projects'
    ],
    'modules' => [
        [
            'title' => 'Introduction to UX Design',
            'lessons' => [
                'What is UX Design?',
                'The UX Design Process',
                'UX vs UI: Understanding the Difference',
                'The Business Value of Good UX'
            ],
            'duration' => '1 hour 45 minutes'
        ],
        [
            'title' => 'User Research Fundamentals',
            'lessons' => [
                'Research Methods Overview',
                'User Interviews',
                'Surveys and Questionnaires',
                'Competitive Analysis',
                'Creating User Personas'
            ],
            'duration' => '2 hours 30 minutes'
        ],
        [
            'title' => 'Information Architecture',
            'lessons' => [
                'Organizing Content Effectively',
                'Card Sorting Techniques',
                'Site Mapping',
                'Navigation Patterns'
            ],
            'duration' => '2 hours'
        ],
        [
            'title' => 'Wireframing and Prototyping',
            'lessons' => [
                'Sketching Basics',
                'Digital Wireframing Tools',
                'Creating Low-Fidelity Prototypes',
                'Interactive Prototyping',
                'Prototype Testing'
            ],
            'duration' => '3 hours 15 minutes'
        ],
        [
            'title' => 'Usability Testing',
            'lessons' => [
                'Usability Testing Methods',
                'Planning a Usability Test',
                'Conducting Test Sessions',
                'Analyzing Test Results',
                'Iterating on Your Design'
            ],
            'duration' => '2 hours 45 minutes'
        ],
        [
            'title' => 'Final Project',
            'lessons' => [
                'Project Brief and Requirements',
                'Applying the UX Process',
                'Presenting Your Work',
                'Peer Review Session'
            ],
            'duration' => '4 hours'
        ]
    ]
];

// Calculate total course duration
$total_duration = 0;
$total_lessons = 0;
foreach ($course['modules'] as $module) {
    // Parse duration string like "2 hours 30 minutes"
    preg_match('/(\d+) hour[s]* (?:(\d+) minute[s]*)?/', $module['duration'], $matches);
    $hours = isset($matches[1]) ? intval($matches[1]) : 0;
    $minutes = isset($matches[2]) ? intval($matches[2]) : 0;
    $total_duration += ($hours * 60) + $minutes;
    $total_lessons += count($module['lessons']);
}

// Format total duration
$duration_hours = floor($total_duration / 60);
$duration_minutes = $total_duration % 60;
$formatted_duration = $duration_hours . ' hour' . ($duration_hours != 1 ? 's' : '');
if ($duration_minutes > 0) {
    $formatted_duration .= ' ' . $duration_minutes . ' minute' . ($duration_minutes != 1 ? 's' : '');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> - LearnHub</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container">
        <div class="course-detail">
            <div class="course-header-banner" style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('<?php echo $course['image']; ?>')">
                <div class="container">
                    <div class="course-header-content">
                        <div class="course-breadcrumb">
                            <a href="index.php">Courses</a> / 
                            <a href="index.php?category=<?php echo urlencode($course['category']); ?>"><?php echo htmlspecialchars($course['category']); ?></a> / 
                            <span><?php echo htmlspecialchars($course['title']); ?></span>
                        </div>
                        <h1><?php echo htmlspecialchars($course['title']); ?></h1>
                        <p class="course-tagline"><?php echo htmlspecialchars($course['description']); ?></p>
                        <div class="course-meta-banner">
                            <div class="meta-item">
                                <i data-feather="user"></i>
                                <span><?php echo number_format($course['students']); ?> students</span>
                            </div>
                            <div class="meta-item">
                                <i data-feather="star"></i>
                                <span><?php echo $course['rating']; ?> (<?php echo $course['reviews']; ?> reviews)</span>
                            </div>
                            <div class="meta-item">
                                <i data-feather="clock"></i>
                                <span><?php echo $formatted_duration; ?></span>
                            </div>
                            <div class="meta-item">
                                <i data-feather="book"></i>
                                <span><?php echo $total_lessons; ?> lessons</span>
                            </div>
                            <div class="meta-item">
                                <i data-feather="bar-chart-2"></i>
                                <span><?php echo htmlspecialchars($course['difficulty']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="course-content-wrapper">
                <div class="course-main-content">
                    <section class="course-section">
                        <h2>What You'll Learn</h2>
                        <div class="learning-objectives">
                            <?php foreach ($course['what_youll_learn'] as $objective): ?>
                                <div class="objective-item">
                                    <i data-feather="check-circle"></i>
                                    <span><?php echo htmlspecialchars($objective); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <section class="course-section">
                        <h2>Course Content</h2>
                        <div class="course-modules">
                            <?php foreach ($course['modules'] as $index => $module): ?>
                                <div class="module-accordion">
                                    <div class="module-header">
                                        <div class="module-title-container">
                                            <h3>Module <?php echo $index + 1; ?>: <?php echo htmlspecialchars($module['title']); ?></h3>
                                            <div class="module-meta">
                                                <span><?php echo count($module['lessons']); ?> lessons</span>
                                                <span>•</span>
                                                <span><?php echo htmlspecialchars($module['duration']); ?></span>
                                            </div>
                                        </div>
                                        <button class="module-toggle">
                                            <i data-feather="chevron-down"></i>
                                        </button>
                                    </div>
                                    <div class="module-content">
                                        <ul class="lesson-list">
                                            <?php foreach ($module['lessons'] as $lesson_index => $lesson): ?>
                                                <li class="lesson-item">
                                                    <div class="lesson-info">
                                                        <i data-feather="play-circle"></i>
                                                        <span><?php echo htmlspecialchars($lesson); ?></span>
                                                    </div>
                                                    <a href="lesson.php?course=<?php echo $course['id']; ?>&module=<?php echo $index; ?>&lesson=<?php echo $lesson_index; ?>" class="btn-text">Preview</a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <section class="course-section">
                        <h2>About the Instructor</h2>
                        <div class="instructor-profile">
                            <div class="instructor-header">
                                <img src="<?php echo $course['instructor']['image']; ?>" alt="<?php echo htmlspecialchars($course['instructor']['name']); ?>" class="instructor-image">
                                <div class="instructor-info">
                                    <h3><?php echo htmlspecialchars($course['instructor']['name']); ?></h3>
                                    <div class="instructor-meta">
                                        <div class="meta-item">
                                            <i data-feather="book"></i>
                                            <span><?php echo $course['instructor']['courses']; ?> courses</span>
                                        </div>
                                        <div class="meta-item">
                                            <i data-feather="users"></i>
                                            <span><?php echo number_format($course['instructor']['students']); ?> students</span>
                                        </div>
                                        <div class="meta-item">
                                            <i data-feather="star"></i>
                                            <span><?php echo $course['instructor']['rating']; ?> rating</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="instructor-bio"><?php echo htmlspecialchars($course['instructor']['bio']); ?></p>
                        </div>
                    </section>
                </div>

                <div class="course-sidebar">
                    <div class="course-card-sticky">
                        <div class="course-preview">
                            <img src="<?php echo $course['image']; ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" class="course-preview-image">
                            <button class="preview-play-button">
                                <i data-feather="play"></i>
                            </button>
                        </div>
                        <div class="course-card-content">
                            <div class="course-price"><?php echo '$' . number_format($course['price'], 2); ?></div>
                            <button class="btn btn-primary btn-block">Enroll Now</button>
                            <button class="btn btn-outline btn-block">Add to Wishlist</button>
                            
                            <div class="course-includes">
                                <h3>This Course Includes:</h3>
                                <ul>
                                    <li>
                                        <i data-feather="video"></i>
                                        <span><?php echo $formatted_duration; ?> of video content</span>
                                    </li>
                                    <li>
                                        <i data-feather="file-text"></i>
                                        <span><?php echo $total_lessons; ?> lessons</span>
                                    </li>
                                    <li>
                                        <i data-feather="download"></i>
                                        <span>Downloadable resources</span>
                                    </li>
                                    <li>
                                        <i data-feather="award"></i>
                                        <span>Certificate of completion</span>
                                    </li>
                                    <li>
                                        <i data-feather="smartphone"></i>
                                        <span>Mobile and TV access</span>
                                    </li>
                                    <li>
                                        <i data-feather="clock"></i>
                                        <span>Lifetime access</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="course-share">
                                <h3>Share This Course:</h3>
                                <div class="social-buttons">
                                    <button class="social-btn facebook">
                                        <i data-feather="facebook"></i>
                                    </button>
                                    <button class="social-btn twitter">
                                        <i data-feather="twitter"></i>
                                    </button>
                                    <button class="social-btn linkedin">
                                        <i data-feather="linkedin"></i>
                                    </button>
                                    <button class="social-btn mail">
                                        <i data-feather="mail"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            
            // Module accordion functionality
            const moduleToggles = document.querySelectorAll('.module-toggle');
            
            moduleToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const moduleAccordion = this.closest('.module-accordion');
                    moduleAccordion.classList.toggle('active');
                    
                    // Update icon
                    const icon = this.querySelector('i');
                    if (moduleAccordion.classList.contains('active')) {
                        icon.setAttribute('data-feather', 'chevron-up');
                    } else {
                        icon.setAttribute('data-feather', 'chevron-down');
                    }
                    feather.replace();
                });
            });
            
            // Preview video functionality
            const previewButton = document.querySelector('.preview-play-button');
            if (previewButton) {
                previewButton.addEventListener('click', function() {
                    alert('Course preview video would play here.');
                });
            }
        });
    </script>
</body>
</html>