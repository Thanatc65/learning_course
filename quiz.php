<?php
// In a real application, you would fetch this data from a database
$course_id = isset($_GET['course']) ? intval($_GET['course']) : 1;
$module_index = isset($_GET['module']) ? intval($_GET['module']) : 0;
$is_review = isset($_GET['review']) && $_GET['review'] == 1;
$is_practice = isset($_GET['practice']) && $_GET['practice'] == 1;

// Sample course data
$course = [
    'id' => $course_id,
    'title' => 'UX Design Fundamentals',
    'modules' => [
        [
            'title' => 'Introduction to UX Design',
            'quiz' => [
                'title' => 'Introduction to UX Design Quiz',
                'description' => 'Test your knowledge of UX design fundamentals.',
                'time_limit' => 15, // minutes
                'passing_score' => 70,
                'questions' => [
                    [
                        'id' => 1,
                        'type' => 'multiple_choice',
                        'question' => 'What does UX stand for?',
                        'options' => [
                            'User Experience',
                            'User Extension',
                            'User Examination',
                            'User Extraction'
                        ],
                        'correct_answer' => 0,
                        'explanation' => 'UX stands for User Experience, which encompasses all aspects of the end-user\'s interaction with the company, its services, and its products.'
                    ],
                    [
                        'id' => 2,
                        'type' => 'multiple_choice',
                        'question' => 'Which of the following is NOT typically a part of the UX design process?',
                        'options' => [
                            'User Research',
                            'Wireframing',
                            'Server Configuration',
                            'Usability Testing'
                        ],
                        'correct_answer' => 2,
                        'explanation' => 'Server Configuration is a technical development task and not typically part of the UX design process, which focuses on understanding users and designing interfaces.'
                    ],
                    [
                        'id' => 3,
                        'type' => 'true_false',
                        'question' => 'UX design and UI design refer to the same discipline.',
                        'options' => [
                            'True',
                            'False'
                        ],
                        'correct_answer' => 1,
                        'explanation' => 'While related, UX (User Experience) design and UI (User Interface) design are different disciplines. UX design focuses on the overall feel of the experience, while UI design focuses on the visual elements of the interface.'
                    ],
                    [
                        'id' => 4,
                        'type' => 'multiple_choice',
                        'question' => 'Which of the following best describes the primary goal of UX design?',
                        'options' => [
                            'To create visually appealing interfaces',
                            'To optimize the user\'s experience with a product',
                            'To maximize company profits',
                            'To implement the latest design trends'
                        ],
                        'correct_answer' => 1,
                        'explanation' => 'The primary goal of UX design is to optimize the user\'s experience with a product, making it easy, efficient, and enjoyable to use.'
                    ],
                    [
                        'id' => 5,
                        'type' => 'multiple_select',
                        'question' => 'Which of the following are common UX research methods? (Select all that apply)',
                        'options' => [
                            'User Interviews',
                            'Usability Testing',
                            'Code Debugging',
                            'Surveys'
                        ],
                        'correct_answers' => [0, 1, 3],
                        'explanation' => 'User interviews, usability testing, and surveys are all common UX research methods. Code debugging is a development activity, not a UX research method.'
                    ]
                ]
            ]
        ],
        [
            'title' => 'User Research Fundamentals',
            'quiz' => [
                'title' => 'User Research Quiz',
                'description' => 'Test your knowledge of user research methods and techniques.',
                'time_limit' => 20,
                'passing_score' => 70,
                'questions' => [
                    [
                        'id' => 1,
                        'type' => 'multiple_choice',
                        'question' => 'What is the primary purpose of user research in UX design?',
                        'options' => [
                            'To validate the designer\'s assumptions',
                            'To understand user needs, behaviors, and motivations',
                            'To create visually appealing designs',
                            'To speed up the development process'
                        ],
                        'correct_answer' => 1,
                        'explanation' => 'The primary purpose of user research is to understand user needs, behaviors, and motivations, which helps designers create products that truly meet user needs.'
                    ],
                    [
                        'id' => 2,
                        'type' => 'multiple_choice',
                        'question' => 'Which research method involves observing users in their natural environment?',
                        'options' => [
                            'A/B Testing',
                            'Surveys',
                            'Contextual Inquiry',
                            'Card Sorting'
                        ],
                        'correct_answer' => 2,
                        'explanation' => 'Contextual Inquiry is a research method that involves observing and interviewing users in their natural environment while they perform tasks.'
                    ]
                ]
            ]
        ]
    ]
];

// Get current module and quiz
$module = $course['modules'][$module_index] ?? $course['modules'][0];
$quiz = $module['quiz'];

// For review mode, we'll simulate some user answers
$user_answers = [];
if ($is_review) {
    foreach ($quiz['questions'] as $q_index => $question) {
        if ($question['type'] == 'multiple_select') {
            $user_answers[$q_index] = [0, 1, 3]; // Simulating user selected options 0, 1, and 3
        } else {
            $user_answers[$q_index] = $question['correct_answer']; // For simplicity, assume user got all correct in review mode
        }
    }
}

// For practice mode, we'll create a mix of questions from all modules
if ($is_practice) {
    $practice_questions = [];
    foreach ($course['modules'] as $m) {
        if (isset($m['quiz']) && isset($m['quiz']['questions'])) {
            // Take 2 random questions from each module
            $module_questions = $m['quiz']['questions'];
            shuffle($module_questions);
            $practice_questions = array_merge($practice_questions, array_slice($module_questions, 0, 2));
        }
    }
    
    $quiz = [
        'title' => 'Practice Quiz',
        'description' => 'Test your knowledge with questions from all modules.',
        'time_limit' => 15,
        'passing_score' => 70,
        'questions' => $practice_questions
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quiz['title']); ?> - LearnHub</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="quiz-page">
    <header class="quiz-header">
        <div class="quiz-header-left">
            <a href="index.php" class="logo">LearnHub</a>
            <div class="quiz-title-container">
                <h1 class="quiz-title"><?php echo htmlspecialchars($quiz['title']); ?></h1>
                <div class="quiz-breadcrumb">
                    <a href="course-detail.php?id=<?php echo $course_id; ?>"><?php echo htmlspecialchars($course['title']); ?></a>
                    <?php if (!$is_practice): ?>
                    / <a href="progress.php?course=<?php echo $course_id; ?>"><?php echo htmlspecialchars($module['title']); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="quiz-header-right">
            <?php if (!$is_review): ?>
                <div class="quiz-timer" id="quiz-timer">
                    <i data-feather="clock"></i>
                    <span id="timer-display"><?php echo $quiz['time_limit']; ?>:00</span>
                </div>
            <?php endif; ?>
            <a href="progress.php?course=<?php echo $course_id; ?>" class="btn btn-outline">
                <i data-feather="x"></i> Exit Quiz
            </a>
        </div>
    </header>

    <main class="quiz-container">
        <?php if ($is_review): ?>
            <div class="quiz-review-banner">
                <div class="review-score">
                    <div class="score-circle">
                        <span>92%</span>
                    </div>
                </div>
                <div class="review-message">
                    <h2>Great job!</h2>
                    <p>You've passed the quiz with a score of 92%. Review your answers below.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="quiz-intro">
                <div class="quiz-info">
                    <h2><?php echo htmlspecialchars($quiz['title']); ?></h2>
                    <p><?php echo htmlspecialchars($quiz['description']); ?></p>
                    <div class="quiz-meta">
                        <div class="meta-item">
                            <i data-feather="help-circle"></i>
                            <span><?php echo count($quiz['questions']); ?> questions</span>
                        </div>
                        <div class="meta-item">
                            <i data-feather="clock"></i>
                            <span><?php echo $quiz['time_limit']; ?> minutes</span>
                        </div>
                        <div class="meta-item">
                            <i data-feather="award"></i>
                            <span>Passing score: <?php echo $quiz['passing_score']; ?>%</span>
                        </div>
                    </div>
                </div>
                <div class="quiz-start">
                    <button id="start-quiz" class="btn btn-primary btn-lg">
                        Start Quiz
                    </button>
                </div>
            </div>
        <?php endif; ?>
        
        <div id="quiz-content" class="quiz-content <?php echo $is_review ? 'show' : ''; ?>">
            <div class="quiz-progress-bar">
                <div class="progress-track">
                    <div class="progress-fill" style="width: 0%"></div>
                </div>
                <div class="progress-labels">
                    <span class="current-question">Question <span id="current-question-num">1</span> of <?php echo count($quiz['questions']); ?></span>
                    <span class="progress-percentage"><span id="progress-percentage">0</span>% Complete</span>
                </div>
            </div>
            
            <form id="quiz-form" class="quiz-form">
                <?php foreach ($quiz['questions'] as $q_index => $question): ?>
                    <div class="question-card <?php echo $q_index === 0 ? 'active' : ''; ?> <?php echo $is_review ? 'review-mode' : ''; ?>" data-question="<?php echo $q_index + 1; ?>">
                        <div class="question-header">
                            <span class="question-number">Question <?php echo $q_index + 1; ?></span>
                            <span class="question-type">
                                <?php 
                                switch ($question['type']) {
                                    case 'multiple_choice':
                                        echo 'Multiple Choice';
                                        break;
                                    case 'true_false':
                                        echo 'True/False';
                                        break;
                                    case 'multiple_select':
                                        echo 'Multiple Select';
                                        break;
                                    default:
                                        echo 'Question';
                                }
                                ?>
                            </span>
                        </div>
                        
                        <div class="question-content">
                            <h3><?php echo htmlspecialchars($question['question']); ?></h3>
                            
                            <?php if ($question['type'] == 'multiple_select'): ?>
                                <p class="question-instruction">Select all that apply</p>
                            <?php endif; ?>
                            
                            <div class="options-list">
                                <?php foreach ($question['options'] as $o_index => $option): ?>
                                    <?php 
                                    $is_correct = false;
                                    $is_selected = false;
                                    
                                    if ($is_review) {
                                        if ($question['type'] == 'multiple_select') {
                                            $is_correct = in_array($o_index, $question['correct_answers']);
                                            $is_selected = in_array($o_index, $user_answers[$q_index]);
                                        } else {
                                            $is_correct = $o_index === $question['correct_answer'];
                                            $is_selected = $o_index === $user_answers[$q_index];
                                        }
                                    }
                                    
                                    $option_class = '';
                                    if ($is_review) {
                                        if ($is_selected && $is_correct) {
                                            $option_class = 'correct';
                                        } else if ($is_selected && !$is_correct) {
                                            $option_class = 'incorrect';
                                        } else if (!$is_selected && $is_correct) {
                                            $option_class = 'correct missed';
                                        }
                                    }
                                    ?>
                                    
                                    <div class="option-item <?php echo $option_class; ?>">
                                        <?php if ($question['type'] == 'multiple_select'): ?>
                                            <label class="option-label checkbox">
                                                <input type="checkbox" name="q<?php echo $question['id']; ?>[]" value="<?php echo $o_index; ?>" <?php echo $is_review ? 'disabled' : ''; ?> <?php echo ($is_review && $is_selected) ? 'checked' : ''; ?>>
                                                <span class="checkmark"></span>
                                                <span class="option-text"><?php echo htmlspecialchars($option); ?></span>
                                            </label>
                                        <?php else: ?>
                                            <label class="option-label radio">
                                                <input type="radio" name="q<?php echo $question['id']; ?>" value="<?php echo $o_index; ?>" <?php echo $is_review ? 'disabled' : ''; ?> <?php echo ($is_review && $is_selected) ? 'checked' : ''; ?>>
                                                <span class="radiomark"></span>
                                                <span class="option-text"><?php echo htmlspecialchars($option); ?></span>
                                            </label>
                                        <?php endif; ?>
                                        
                                        <?php if ($is_review): ?>
                                            <?php if ($is_selected && !$is_correct): ?>
                                                <div class="option-feedback incorrect">
                                                    <i data-feather="x"></i>
                                                    <span>Incorrect</span>
                                                </div>
                                            <?php elseif (($is_selected && $is_correct) || (!$is_selected && $is_correct)): ?>
                                                <div class="option-feedback correct">
                                                    <i data-feather="check"></i>
                                                    <span>Correct</span>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <?php if ($is_review): ?>
                                <div class="question-explanation">
                                    <h4>Explanation</h4>
                                    <p><?php echo htmlspecialchars($question['explanation']); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="question-footer">
                            <?php if ($q_index > 0): ?>
                                <button type="button" class="btn btn-outline prev-question">Previous</button>
                            <?php else: ?>
                                <div></div>
                            <?php endif; ?>
                            
                            <?php if ($q_index < count($quiz['questions']) - 1): ?>
                                <button type="button" class="btn btn-primary next-question">Next</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-primary submit-quiz" <?php echo $is_review ? 'disabled' : ''; ?>>Submit Quiz</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </form>
            
            <?php if ($is_review): ?>
                <div class="review-actions">
                    <a href="progress.php?course=<?php echo $course_id; ?>" class="btn btn-primary">
                        Back to Progress
                    </a>
                    <a href="quiz.php?course=<?php echo $course_id; ?>&module=<?php echo $module_index; ?>" class="btn btn-outline">
                        Retake Quiz
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <div id="quiz-results" class="quiz-results">
        <div class="results-content">
            <div class="results-header">
                <h2>Quiz Results</h2>
                <button id="close-results" class="btn-icon">
                    <i data-feather="x"></i>
                </button>
            </div>
            
            <div class="results-score">
                <div class="score-circle">
                    <span id="final-score">0%</span>
                </div>
                <div id="pass-fail-message" class="pass-fail-message">
                    <!-- Will be filled by JavaScript -->
                </div>
            </div>
            
            <div class="results-breakdown">
                <h3>Question Breakdown</h3>
                <div class="breakdown-stats">
                    <div class="stat-item">
                        <div class="stat-value" id="correct-count">0</div>
                        <div class="stat-label">Correct</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="incorrect-count">0</div>
                        <div class="stat-label">Incorrect</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="unanswered-count">0</div>
                        <div class="stat-label">Unanswered</div>
                    </div>
                </div>
            </div>
            
            <div class="results-actions">
                <a href="quiz.php?course=<?php echo $course_id; ?>&module=<?php echo $module_index; ?>&review=1" class="btn btn-primary">
                    Review Answers
                </a>
                <a href="progress.php?course=<?php echo $course_id; ?>" class="btn btn-outline">
                    Back to Progress
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            
            const startQuizBtn = document.getElementById('start-quiz');
            const quizIntro = document.querySelector('.quiz-intro');
            const quizContent = document.getElementById('quiz-content');
            const quizForm = document.getElementById('quiz-form');
            const quizResults = document.getElementById('quiz-results');
            const closeResultsBtn = document.getElementById('close-results');
            const timerDisplay = document.getElementById('timer-display');
            const progressFill = document.querySelector('.progress-fill');
            const currentQuestionNum = document.getElementById('current-question-num');
            const progressPercentage = document.getElementById('progress-percentage');
            
            const questions = document.querySelectorAll('.question-card');
            const totalQuestions = questions.length;
            let currentQuestion = 1;
            
            // Start quiz
            if (startQuizBtn) {
                startQuizBtn.addEventListener('click', function() {
                    quizIntro.style.display = 'none';
                    quizContent.classList.add('show');
                    startTimer();
                });
            }
            
            // Timer functionality
            let timeLeft = <?php echo $quiz['time_limit']; ?> * 60; // convert to seconds
            let timerInterval;
            
            function startTimer() {
                if (!timerDisplay) return;
                
                timerInterval = setInterval(function() {
                    timeLeft--;
                    
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    
                    timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                    
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        submitQuiz();
                    }
                }, 1000);
            }
            
            // Navigation between questions
            const nextButtons = document.querySelectorAll('.next-question');
            const prevButtons = document.querySelectorAll('.prev-question');
            
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (currentQuestion < totalQuestions) {
                        showQuestion(currentQuestion + 1);
                    }
                });
            });
            
            prevButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (currentQuestion > 1) {
                        showQuestion(currentQuestion - 1);
                    }
                });
            });
            
            function showQuestion(questionNumber) {
                questions.forEach(question => {
                    question.classList.remove('active');
                });
                
                const questionToShow = document.querySelector(`.question-card[data-question="${questionNumber}"]`);
                if (questionToShow) {
                    questionToShow.classList.add('active');
                    currentQuestion = questionNumber;
                    updateProgress();
                }
            }
            
            function updateProgress() {
                if (currentQuestionNum) {
                    currentQuestionNum.textContent = currentQuestion;
                }
                
                const progress = (currentQuestion / totalQuestions) * 100;
                
                if (progressFill) {
                    progressFill.style.width = `${progress}%`;
                }
                
                if (progressPercentage) {
                    progressPercentage.textContent = Math.round(progress);
                }
            }
            
            // Submit quiz
            if (quizForm) {
                quizForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitQuiz();
                });
            }
            
            function submitQuiz() {
                if (timerInterval) {
                    clearInterval(timerInterval);
                }
                
                // In a real application, you would send the form data to the server
                // and get the results back. For this demo, we'll simulate results.
                
                const correctCount = Math.floor(Math.random() * 3) + 3; // Random between 3-5 correct
                const incorrectCount = Math.floor(Math.random() * 2) + 1; // Random between 1-2 incorrect
                const unansweredCount = totalQuestions - correctCount - incorrectCount;
                
                const score = Math.round((correctCount / totalQuestions) * 100);
                const isPassing = score >= <?php echo $quiz['passing_score']; ?>;
                
                // Update results modal
                document.getElementById('final-score').textContent = `${score}%`;
                document.getElementById('correct-count').textContent = correctCount;
                document.getElementById('incorrect-count').textContent = incorrectCount;
                document.getElementById('unanswered-count').textContent = unansweredCount;
                
                const passFailMessage = document.getElementById('pass-fail-message');
                if (isPassing) {
                    passFailMessage.innerHTML = '<div class="pass-message">Congratulations! You passed the quiz.</div>';
                    passFailMessage.classList.add('pass');
                    passFailMessage.classList.remove('fail');
                } else {
                    passFailMessage.innerHTML = `<div class="fail-message">You didn't pass this time. You need ${<?php echo $quiz['passing_score']; ?>}% to pass.</div>`;
                    passFailMessage.classList.add('fail');
                    passFailMessage.classList.remove('pass');
                }
                
                // Show results modal
                quizResults.classList.add('show');
            }
            
            // Close results modal
            if (closeResultsBtn) {
                closeResultsBtn.addEventListener('click', function() {
                    quizResults.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>