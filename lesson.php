<?php
// In a real application, you would fetch this data from a database
$course_id = isset($_GET['course']) ? intval($_GET['course']) : 1;
$module_index = isset($_GET['module']) ? intval($_GET['module']) : 0;
$lesson_index = isset($_GET['lesson']) ? intval($_GET['lesson']) : 0;

// Sample course data
$courses = [
    1 => [
        'title' => 'UX Design Fundamentals',
        'modules' => [
            [
                'title' => 'Introduction to UX Design',
                'lessons' => [
                    [
                        'title' => 'What is UX Design?',
                        'video' => '/placeholder.svg?height=500&width=900',
                        'duration' => '12:45',
                        'content' => '<p>User Experience (UX) design is the process of creating products that provide meaningful and relevant experiences to users. This involves the design of the entire process of acquiring and integrating the product, including aspects of branding, design, usability, and function.</p>
                        <p>UX design encompasses all aspects of the end-user\'s interaction with the company, its services, and its products. The goal of UX design is to create easy, efficient, relevant, and all-around pleasant experiences for the user.</p>
                        <h3>Key Components of UX Design</h3>
                        <ul>
                            <li><strong>User Research:</strong> Understanding the needs, behaviors, and motivations of users through observation techniques, task analysis, and other feedback methodologies.</li>
                            <li><strong>Information Architecture:</strong> Organizing and structuring content in a way that helps users find information and complete tasks.</li>
                            <li><strong>Interaction Design:</strong> Designing with the goal of facilitating interactions between users and products.</li>
                            <li><strong>Visual Design:</strong> Creating engaging interfaces with well thought out branding, color, imagery, typography, and space.</li>
                            <li><strong>Usability:</strong> Ensuring a product is easy to use and efficient.</li>
                            <li><strong>Accessibility:</strong> Making sure products can be used by people with a wide range of abilities.</li>  Making sure products can be used by people with a wide range of abilities.</li>
                        </ul>
                        <h3>The UX Design Process</h3>
                        <p>The UX design process typically follows these key stages:</p>
                        <ol>
                            <li><strong>Research:</strong> Gathering insights about user needs and behaviors</li>
                            <li><strong>Analysis:</strong> Interpreting research data to identify patterns and opportunities</li>
                            <li><strong>Design:</strong> Creating solutions based on research insights</li>
                            <li><strong>Testing:</strong> Validating designs with real users</li>
                            <li><strong>Implementation:</strong> Working with developers to bring designs to life</li>
                            <li><strong>Evaluation:</strong> Measuring the success of the design in meeting user needs</li>
                        </ol>'
                    ],
                    [
                        'title' => 'UX vs UI: Understanding the Difference',
                        'video' => '/placeholder.svg?height=500&width=900',
                        'duration' => '15:20',
                        'content' => '<p>While UX and UI design work closely together, they refer to different aspects of the product development process and design discipline.</p>'
                    ],
                    [
                        'title' => 'The UX Design Process',
                        'video' => '/placeholder.svg?height=500&width=900',
                        'duration' => '18:30',
                        'content' => '<p>The UX design process is iterative and user-centered, focusing on understanding users and their needs at every stage.</p>'
                    ],
                    [
                        'title' => 'The Business Value of Good UX',
                        'video' => '/placeholder.svg?height=500&width=900',
                        'duration' => '14:15',
                        'content' => '<p>Good UX design can significantly impact business metrics, from increased conversion rates to reduced support costs.</p>'
                    ]
                ]
            ],
            [
                'title' => 'User Research Fundamentals',
                'lessons' => [
                    [
                        'title' => 'Research Methods Overview',
                        'video' => '/placeholder.svg?height=500&width=900',
                        'duration' => '20:10',
                        'content' => '<p>User research methods can be qualitative or quantitative, and each serves different purposes in the UX design process.</p>'
                    ]
                ]
            ]
        ]
    ]
];

// Get current course, module and lesson
$course = $courses[$course_id] ?? $courses[1];
$module = $course['modules'][$module_index] ?? $course['modules'][0];
$lesson = $module['lessons'][$lesson_index] ?? $module['lessons'][0];

// Calculate progress
$total_lessons = 0;
$completed_lessons = 0;
foreach ($course['modules'] as $m) {
    $total_lessons += count($m['lessons']);
}

// For demo purposes, we'll consider all lessons before the current one as completed
for ($i = 0; $i < $module_index; $i++) {
    $completed_lessons += count($course['modules'][$i]['lessons']);
}
for ($i = 0; $i < $lesson_index; $i++) {
    $completed_lessons++;
}

$progress_percentage = ($total_lessons > 0) ? round(($completed_lessons / $total_lessons) * 100) : 0;

// Get next and previous lesson
$prev_lesson = null;
$next_lesson = null;

// Previous lesson
if ($lesson_index > 0) {
    $prev_lesson = [
        'course' => $course_id,
        'module' => $module_index,
        'lesson' => $lesson_index - 1,
        'title' => $module['lessons'][$lesson_index - 1]['title']
    ];
} elseif ($module_index > 0) {
    $prev_module = $course['modules'][$module_index - 1];
    $prev_lesson_index = count($prev_module['lessons']) - 1;
    $prev_lesson = [
        'course' => $course_id,
        'module' => $module_index - 1,
        'lesson' => $prev_lesson_index,
        'title' => $prev_module['lessons'][$prev_lesson_index]['title']
    ];
}

// Next lesson
if ($lesson_index < count($module['lessons']) - 1) {
    $next_lesson = [
        'course' => $course_id,
        'module' => $module_index,
        'lesson' => $lesson_index + 1,
        'title' => $module['lessons'][$lesson_index + 1]['title']
    ];
} elseif ($module_index < count($course['modules']) - 1) {
    $next_lesson = [
        'course' => $course_id,
        'module' => $module_index + 1,
        'lesson' => 0,
        'title' => $course['modules'][$module_index + 1]['lessons'][0]['title']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($lesson['title']); ?> - LearnHub</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="lesson-page">
    <header class="lesson-header">
        <div class="lesson-header-left">
            <a href="index.php" class="logo">LearnHub</a>
            <div class="lesson-title-container">
                <h1 class="lesson-title"><?php echo htmlspecialchars($lesson['title']); ?></h1>
                <div class="lesson-breadcrumb">
                    <a href="course-detail.php?id=<?php echo $course_id; ?>"><?php echo htmlspecialchars($course['title']); ?></a> / 
                    <span><?php echo htmlspecialchars($module['title']); ?></span>
                </div>
            </div>
        </div>
        <div class="lesson-header-right">
            <div class="lesson-progress">
                <div class="progress-text"><?php echo $progress_percentage; ?>% complete</div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: <?php echo $progress_percentage; ?>%"></div>
                </div>
            </div>
            <button id="toggle-sidebar" class="btn-icon">
                <i data-feather="menu"></i>
            </button>
        </div>
    </header>

    <div class="lesson-container">
        <aside id="lesson-sidebar" class="lesson-sidebar">
            <div class="sidebar-header">
                <h2>Course Content</h2>
                <button id="close-sidebar" class="btn-icon">
                    <i data-feather="x"></i>
                </button>
            </div>
            
            <div class="course-modules-list">
                <?php foreach ($course['modules'] as $m_index => $m): ?>
                    <div class="sidebar-module <?php echo ($m_index === $module_index) ? 'active' : ''; ?>">
                        <div class="sidebar-module-header">
                            <h3><?php echo htmlspecialchars($m['title']); ?></h3>
                            <i data-feather="chevron-down"></i>
                        </div>
                        <ul class="sidebar-lessons <?php echo ($m_index === $module_index) ? 'show' : ''; ?>">
                            <?php foreach ($m['lessons'] as $l_index => $l): ?>
                                <li class="sidebar-lesson <?php echo ($m_index === $module_index && $l_index === $lesson_index) ? 'active' : ''; ?> <?php echo ($m_index < $module_index || ($m_index === $module_index && $l_index < $lesson_index)) ? 'completed' : ''; ?>">
                                    <a href="lesson.php?course=<?php echo $course_id; ?>&module=<?php echo $m_index; ?>&lesson=<?php echo $l_index; ?>">
                                        <?php if ($m_index < $module_index || ($m_index === $module_index && $l_index < $lesson_index)): ?>
                                            <i data-feather="check-circle"></i>
                                        <?php elseif ($m_index === $module_index && $l_index === $lesson_index): ?>
                                            <i data-feather="play-circle"></i>
                                        <?php else: ?>
                                            <i data-feather="circle"></i>
                                        <?php endif; ?>
                                        <span><?php echo htmlspecialchars($l['title']); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="sidebar-footer">
                <a href="progress.php?course=<?php echo $course_id; ?>" class="btn btn-outline btn-block">
                    <i data-feather="bar-chart-2"></i> View Progress
                </a>
            </div>
        </aside>

        <main class="lesson-content">
            <div class="video-container">
                <div class="video-wrapper">
                    <img src="<?php echo $lesson['video']; ?>" alt="Video thumbnail" class="video-placeholder">
                    <div class="video-controls">
                        <button class="video-play-btn">
                            <i data-feather="play"></i>
                        </button>
                        <div class="video-info">
                            <span class="video-title"><?php echo htmlspecialchars($lesson['title']); ?></span>
                            <span class="video-duration"><?php echo $lesson['duration']; ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="video-toolbar">
                    <div class="toolbar-left">
                        <button class="btn-icon" title="Add note">
                            <i data-feather="edit-2"></i>
                        </button>
                        <button class="btn-icon" title="Download resources">
                            <i data-feather="download"></i>
                        </button>
                        <button class="btn-icon" title="Bookmark">
                            <i data-feather="bookmark"></i>
                        </button>
                    </div>
                    <div class="toolbar-right">
                        <button class="btn-icon" title="Playback speed">
                            <i data-feather="settings"></i> 1x
                        </button>
                        <button class="btn-icon" title="Full screen">
                            <i data-feather="maximize"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="lesson-text-content">
                <h2><?php echo htmlspecialchars($lesson['title']); ?></h2>
                <div class="lesson-text">
                    <?php echo $lesson['content']; ?>
                </div>
                
                <div class="lesson-resources">
                    <h3>Lesson Resources</h3>
                    <ul class="resources-list">
                        <li>
                            <i data-feather="file-text"></i>
                            <span>Lesson Transcript</span>
                            <a href="#" class="btn-text">Download</a>
                        </li>
                        <li>
                            <i data-feather="file"></i>
                            <span>UX Design Principles Cheat Sheet</span>
                            <a href="#" class="btn-text">Download</a>
                        </li>
                        <li>
                            <i data-feather="link"></i>
                            <span>Additional Reading Materials</span>
                            <a href="#" class="btn-text">View</a>
                        </li>
                    </ul>
                </div>
                
                <div class="lesson-complete-container">
                    <button id="mark-complete" class="btn btn-primary">
                        <i data-feather="check-circle"></i> Mark as Complete
                    </button>
                    
                    <?php if ($next_lesson): ?>
                        <a href="lesson.php?course=<?php echo $next_lesson['course']; ?>&module=<?php echo $next_lesson['module']; ?>&lesson=<?php echo $next_lesson['lesson']; ?>" class="btn btn-outline">
                            Next Lesson <i data-feather="arrow-right"></i>
                        </a>
                    <?php else: ?>
                        <a href="quiz.php?course=<?php echo $course_id; ?>&module=<?php echo $module_index; ?>" class="btn btn-outline">
                            Take Module Quiz <i data-feather="arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="lesson-navigation">
                <?php if ($prev_lesson): ?>
                    <a href="lesson.php?course=<?php echo $prev_lesson['course']; ?>&module=<?php echo $prev_lesson['module']; ?>&lesson=<?php echo $prev_lesson['lesson']; ?>" class="nav-link prev">
                        <i data-feather="arrow-left"></i>
                        <div class="nav-text">
                            <span class="nav-label">Previous Lesson</span>
                            <span class="nav-title"><?php echo htmlspecialchars($prev_lesson['title']); ?></span>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="nav-link disabled"></div>
                <?php endif; ?>
                
                <?php if ($next_lesson): ?>
                    <a href="lesson.php?course=<?php echo $next_lesson['course']; ?>&module=<?php echo $next_lesson['module']; ?>&lesson=<?php echo $next_lesson['lesson']; ?>" class="nav-link next">
                        <div class="nav-text">
                            <span class="nav-label">Next Lesson</span>
                            <span class="nav-title"><?php echo htmlspecialchars($next_lesson['title']); ?></span>
                        </div>
                        <i data-feather="arrow-right"></i>
                    </a>
                <?php else: ?>
                    <a href="quiz.php?course=<?php echo $course_id; ?>&module=<?php echo $module_index; ?>" class="nav-link next">
                        <div class="nav-text">
                            <span class="nav-label">Next Step</span>
                            <span class="nav-title">Module Quiz</span>
                        </div>
                        <i data-feather="arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            
            // Toggle sidebar
            const toggleSidebarBtn = document.getElementById('toggle-sidebar');
            const closeSidebarBtn = document.getElementById('close-sidebar');
            const sidebar = document.getElementById('lesson-sidebar');
            
            if (toggleSidebarBtn && sidebar) {
                toggleSidebarBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
            
            if (closeSidebarBtn && sidebar) {
                closeSidebarBtn.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                });
            }
            
            // Module accordion in sidebar
            const moduleHeaders = document.querySelectorAll('.sidebar-module-header');
            
            moduleHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const module = this.parentElement;
                    const lessonsList = module.querySelector('.sidebar-lessons');
                    
                    module.classList.toggle('active');
                    lessonsList.classList.toggle('show');
                    
                    // Update icon
                    const icon = this.querySelector('i');
                    if (module.classList.contains('active')) {
                        icon.setAttribute('data-feather', 'chevron-up');
                    } else {
                        icon.setAttribute('data-feather', 'chevron-down');
                    }
                    feather.replace();
                });
            });
            
            // Video play button
            const videoPlayBtn = document.querySelector('.video-play-btn');
            if (videoPlayBtn) {
                videoPlayBtn.addEventListener('click', function() {
                    alert('Video would play here in a real application.');
                });
            }
            
            // Mark as complete button
            const markCompleteBtn = document.getElementById('mark-complete');
            if (markCompleteBtn) {
                markCompleteBtn.addEventListener('click', function() {
                    this.classList.add('completed');
                    this.innerHTML = '<i data-feather="check-circle"></i> Completed';
                    feather.replace();
                    
                    // Update progress bar
                    const progressBar = document.querySelector('.progress-bar');
                    const progressText = document.querySelector('.progress-text');
                    
                    if (progressBar && progressText) {
                        const currentProgress = parseInt(progressBar.style.width);
                        const newProgress = Math.min(currentProgress + (100 / <?php echo $total_lessons; ?>), 100);
                        
                        progressBar.style.width = newProgress + '%';
                        progressText.textContent = Math.round(newProgress) + '% complete';
                    }
                    
                    // Update sidebar
                    const currentLessonItem = document.querySelector('.sidebar-lesson.active');
                    if (currentLessonItem) {
                        currentLessonItem.classList.add('completed');
                        const icon = currentLessonItem.querySelector('i');
                        icon.setAttribute('data-feather', 'check-circle');
                        feather.replace();
                    }
                    
                    // Show next button
                    const nextButton = this.nextElementSibling;
                    if (nextButton) {
                        nextButton.classList.add('pulse');
                    }
                });
            }
        });
    </script>
</body>
</html>