<?php
// In a real application, you would fetch this data from a database
$course_id = isset($_GET['course']) ? intval($_GET['course']) : 1;

// Sample course data
$course = [
    'id' => $course_id,
    'title' => 'UX Design Fundamentals',
    'modules' => [
        [
            'title' => 'Introduction to UX Design',
            'progress' => 100, // percentage
            'lessons' => [
                ['title' => 'What is UX Design?', 'completed' => true, 'score' => 100],
                ['title' => 'UX vs UI: Understanding the Difference', 'completed' => true, 'score' => 90],
                ['title' => 'The UX Design Process', 'completed' => true, 'score' => 85],
                ['title' => 'The Business Value of Good UX', 'completed' => true, 'score' => 95]
            ],
            'quiz_score' => 92,
            'time_spent' => '2 hours 15 minutes'
        ],
        [
            'title' => 'User Research Fundamentals',
            'progress' => 60,
            'lessons' => [
                ['title' => 'Research Methods Overview', 'completed' => true, 'score' => 88],
                ['title' => 'User Interviews', 'completed' => true, 'score' => 75],
                ['title' => 'Surveys and Questionnaires', 'completed' => true, 'score' => 80],
                ['title' => 'Competitive Analysis', 'completed' => false, 'score' => null],
                ['title' => 'Creating User Personas', 'completed' => false, 'score' => null]
            ],
            'quiz_score' => null,
            'time_spent' => '1 hour 45 minutes'
        ],
        [
            'title' => 'Information Architecture',
            'progress' => 0,
            'lessons' => [
                ['title' => 'Organizing Content Effectively', 'completed' => false, 'score' => null],
                ['title' => 'Card Sorting Techniques', 'completed' => false, 'score' => null],
                ['title' => 'Site Mapping', 'completed' => false, 'score' => null],
                ['title' => 'Navigation Patterns', 'completed' => false, 'score' => null]
            ],
            'quiz_score' => null,
            'time_spent' => '0 minutes'
        ],
        [
            'title' => 'Wireframing and Prototyping',
            'progress' => 0,
            'lessons' => [
                ['title' => 'Sketching Basics', 'completed' => false, 'score' => null],
                ['title' => 'Digital Wireframing Tools', 'completed' => false, 'score' => null],
                ['title' => 'Creating Low-Fidelity Prototypes', 'completed' => false, 'score' => null],
                ['title' => 'Interactive Prototyping', 'completed' => false, 'score' => null],
                ['title' => 'Prototype Testing', 'completed' => false, 'score' => null]
            ],
            'quiz_score' => null,
            'time_spent' => '0 minutes'
        ]
    ]
];

// Calculate overall progress
$total_lessons = 0;
$completed_lessons = 0;

foreach ($course['modules'] as $module) {
    foreach ($module['lessons'] as $lesson) {
        $total_lessons++;
        if ($lesson['completed']) {
            $completed_lessons++;
        }
    }
}

$overall_progress = ($total_lessons > 0) ? round(($completed_lessons / $total_lessons) * 100) : 0;

// Calculate average quiz score
$quiz_scores = [];
foreach ($course['modules'] as $module) {
    if ($module['quiz_score'] !== null) {
        $quiz_scores[] = $module['quiz_score'];
    }
}
$average_quiz_score = !empty($quiz_scores) ? round(array_sum($quiz_scores) / count($quiz_scores)) : 0;

// Calculate total time spent
$total_time_spent = '4 hours'; // In a real app, you would calculate this from the module times
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Progress - <?php echo htmlspecialchars($course['title']); ?> - LearnHub</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container">
        <div class="progress-page">
            <div class="progress-header">
                <div class="breadcrumb">
                    <a href="index.php">Courses</a> / 
                    <a href="course-detail.php?id=<?php echo $course_id; ?>"><?php echo htmlspecialchars($course['title']); ?></a> / 
                    <span>Progress</span>
                </div>
                <h1>Your Progress: <?php echo htmlspecialchars($course['title']); ?></h1>
            </div>
            
            <div class="progress-overview">
                <div class="progress-card">
                    <div class="progress-card-header">
                        <h3>Overall Progress</h3>
                    </div>
                    <div class="progress-card-content">
                        <div class="circular-progress">
                            <div class="circular-progress-inner">
                                <span class="progress-value"><?php echo $overall_progress; ?>%</span>
                                <span class="progress-label">Complete</span>
                            </div>
                            <svg width="160" height="160" viewBox="0 0 160 160">
                                <circle class="progress-bg" cx="80" cy="80" r="70" stroke-width="12" fill="none" />
                                <circle class="progress-bar" cx="80" cy="80" r="70" stroke-width="12" fill="none" 
                                        stroke-dasharray="440" stroke-dashoffset="<?php echo 440 - (440 * $overall_progress / 100); ?>" />
                            </svg>
                        </div>
                        <div class="progress-stats">
                            <div class="stat-item">
                                <i data-feather="book-open"></i>
                                <div class="stat-content">
                                    <span class="stat-value"><?php echo $completed_lessons; ?>/<?php echo $total_lessons; ?></span>
                                    <span class="stat-label">Lessons Completed</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i data-feather="award"></i>
                                <div class="stat-content">
                                    <span class="stat-value"><?php echo $average_quiz_score; ?>%</span>
                                    <span class="stat-label">Average Quiz Score</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i data-feather="clock"></i>
                                <div class="stat-content">
                                    <span class="stat-value"><?php echo $total_time_spent; ?></span>
                                    <span class="stat-label">Total Time Spent</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="progress-card">
                    <div class="progress-card-header">
                        <h3>Performance Overview</h3>
                    </div>
                    <div class="progress-card-content">
                        <div class="chart-container">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="module-progress-section">
                <h2>Module Progress</h2>
                
                <div class="module-progress-list">
                    <?php foreach ($course['modules'] as $index => $module): ?>
                        <div class="module-progress-card">
                            <div class="module-progress-header">
                                <h3><?php echo htmlspecialchars($module['title']); ?></h3>
                                <div class="module-progress-bar-container">
                                    <div class="module-progress-bar" style="width: <?php echo $module['progress']; ?>%"></div>
                                </div>
                                <span class="module-progress-percentage"><?php echo $module['progress']; ?>%</span>
                            </div>
                            
                            <div class="module-progress-content">
                                <div class="module-lessons">
                                    <h4>Lessons</h4>
                                    <ul class="lesson-progress-list">
                                        <?php foreach ($module['lessons'] as $lesson_index => $lesson): ?>
                                            <li class="lesson-progress-item <?php echo $lesson['completed'] ? 'completed' : ''; ?>">
                                                <div class="lesson-progress-info">
                                                    <?php if ($lesson['completed']): ?>
                                                        <i data-feather="check-circle"></i>
                                                    <?php else: ?>
                                                        <i data-feather="circle"></i>
                                                    <?php endif; ?>
                                                    <span><?php echo htmlspecialchars($lesson['title']); ?></span>
                                                </div>
                                                <?php if ($lesson['completed']): ?>
                                                    <div class="lesson-score">
                                                        <span><?php echo $lesson['score']; ?>%</span>
                                                    </div>
                                                <?php else: ?>
                                                    <a href="lesson.php?course=<?php echo $course_id; ?>&module=<?php echo $index; ?>&lesson=<?php echo $lesson_index; ?>" class="btn-text">
                                                        Start
                                                    </a>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                
                                <div class="module-quiz">
                                    <h4>Module Quiz</h4>
                                    <?php if ($module['quiz_score'] !== null): ?>
                                        <div class="quiz-result">
                                            <div class="quiz-score">
                                                <div class="circular-progress small">
                                                    <div class="circular-progress-inner">
                                                        <span class="progress-value"><?php echo $module['quiz_score']; ?>%</span>
                                                    </div>
                                                    <svg width="80" height="80" viewBox="0 0 80 80">
                                                        <circle class="progress-bg" cx="40" cy="40" r="35" stroke-width="6" fill="none" />
                                                        <circle class="progress-bar" cx="40" cy="40" r="35" stroke-width="6" fill="none" 
                                                                stroke-dasharray="220" stroke-dashoffset="<?php echo 220 - (220 * $module['quiz_score'] / 100); ?>" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="quiz-actions">
                                                <a href="quiz.php?course=<?php echo $course_id; ?>&module=<?php echo $index; ?>&review=1" class="btn-text">
                                                    Review Quiz
                                                </a>
                                                <a href="quiz.php?course=<?php echo $course_id; ?>&module=<?php echo $index; ?>" class="btn-text">
                                                    Retake Quiz
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif ($module['progress'] == 100): ?>
                                        <div class="quiz-cta">
                                            <p>You've completed all lessons in this module!</p>
                                            <a href="quiz.php?course=<?php echo $course_id; ?>&module=<?php echo $index; ?>" class="btn btn-primary">
                                                Take Module Quiz
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="quiz-locked">
                                            <i data-feather="lock"></i>
                                            <p>Complete all lessons to unlock the module quiz</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="module-stats">
                                    <div class="stat-item">
                                        <i data-feather="clock"></i>
                                        <div class="stat-content">
                                            <span class="stat-value"><?php echo $module['time_spent']; ?></span>
                                            <span class="stat-label">Time Spent</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="progress-recommendations">
                <h2>Recommended Next Steps</h2>
                <div class="recommendations-grid">
                    <?php 
                    // Find the next incomplete module
                    $next_module_index = null;
                    $next_lesson_index = null;
                    
                    foreach ($course['modules'] as $m_index => $module) {
                        if ($module['progress'] < 100) {
                            $next_module_index = $m_index;
                            // Find the first incomplete lesson
                            foreach ($module['lessons'] as $l_index => $lesson) {
                                if (!$lesson['completed']) {
                                    $next_lesson_index = $l_index;
                                    break;
                                }
                            }
                            break;
                        }
                    }
                    ?>
                    
                    <?php if ($next_module_index !== null && $next_lesson_index !== null): ?>
                        <div class="recommendation-card">
                            <div class="recommendation-icon">
                                <i data-feather="play-circle"></i>
                            </div>
                            <div class="recommendation-content">
                                <h3>Continue Learning</h3>
                                <p>Pick up where you left off in the course.</p>
                                <a href="lesson.php?course=<?php echo $course_id; ?>&module=<?php echo $next_module_index; ?>&lesson=<?php echo $next_lesson_index; ?>" class="btn btn-primary">
                                    Continue to Next Lesson
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="recommendation-card">
                        <div class="recommendation-icon">
                            <i data-feather="award"></i>
                        </div>
                        <div class="recommendation-content">
                            <h3>Practice Quiz</h3>
                            <p>Test your knowledge with a practice quiz.</p>
                            <a href="quiz.php?course=<?php echo $course_id; ?>&practice=1" class="btn btn-outline">
                                Take Practice Quiz
                            </a>
                        </div>
                    </div>
                    
                    <div class="recommendation-card">
                        <div class="recommendation-icon">
                            <i data-feather="users"></i>
                        </div>
                        <div class="recommendation-content">
                            <h3>Join Discussion</h3>
                            <p>Connect with other students in the course forum.</p>
                            <a href="#" class="btn btn-outline">
                                View Forum
                            </a>
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
            
            // Performance chart
            const ctx = document.getElementById('performanceChart').getContext('2d');
            const performanceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Module 1', 'Module 2'],
                    datasets: [{
                        label: 'Quiz Scores',
                        data: [92, null],
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + '%';
                                }
                            }
                        }
                    }
                }
            });
            
            // Circular progress animation
            const circularProgress = document.querySelector('.circular-progress');
            if (circularProgress) {
                const progressBar = circularProgress.querySelector('.progress-bar');
                const progressValue = circularProgress.querySelector('.progress-value');
                const targetProgress = parseInt(progressValue.textContent);
                
                let currentProgress = 0;
                const interval = setInterval(() => {
                    if (currentProgress >= targetProgress) {
                        clearInterval(interval);
                    } else {
                        currentProgress++;
                        progressValue.textContent = currentProgress + '%';
                        progressBar.style.strokeDashoffset = 440 - (440 * currentProgress / 100);
                    }
                }, 20);
            }
        });
    </script>
</body>
</html>