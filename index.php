<?php
// Sample course data - in a real application, this would come from a database
$courses = [
    [
        'id' => 1,
        'title' => 'UX Design Fundamentals',
        'category' => 'Design',
        'difficulty' => 'Beginner',
        'instructor' => 'Sarah Johnson',
        'rating' => 4.8,
        'students' => 2453,
        'image' => '/placeholder.svg?height=200&width=350',
        'price' => 49.99,
        'description' => 'Learn the core principles of user experience design and create intuitive, user-friendly interfaces.'
    ],
    [
        'id' => 2,
        'title' => 'Advanced JavaScript Patterns',
        'category' => 'Development',
        'difficulty' => 'Advanced',
        'instructor' => 'Michael Chen',
        'rating' => 4.9,
        'students' => 1872,
        'image' => '/placeholder.svg?height=200&width=350',
        'price' => 69.99,
        'description' => 'Master advanced JavaScript patterns and techniques used by professional developers.'
    ],
    [
        'id' => 3,
        'title' => 'Data Science Essentials',
        'category' => 'Data',
        'difficulty' => 'Intermediate',
        'instructor' => 'Emily Rodriguez',
        'rating' => 4.7,
        'students' => 3241,
        'image' => '/placeholder.svg?height=200&width=350',
        'price' => 59.99,
        'description' => 'Explore the fundamentals of data science, from data analysis to machine learning basics.'
    ],
    [
        'id' => 4,
        'title' => 'Digital Marketing Masterclass',
        'category' => 'Marketing',
        'difficulty' => 'Beginner',
        'instructor' => 'David Wilson',
        'rating' => 4.6,
        'students' => 5123,
        'image' => '/placeholder.svg?height=200&width=350',
        'price' => 39.99,
        'description' => 'Learn proven digital marketing strategies to grow your business and increase conversions.'
    ],
    [
        'id' => 5,
        'title' => 'Full-Stack Web Development',
        'category' => 'Development',
        'difficulty' => 'Intermediate',
        'instructor' => 'Alex Thompson',
        'rating' => 4.9,
        'students' => 2789,
        'image' => '/placeholder.svg?height=200&width=350',
        'price' => 79.99,
        'description' => 'Build complete web applications from front to back with modern technologies.'
    ],
    [
        'id' => 6,
        'title' => 'UI Design with Figma',
        'category' => 'Design',
        'difficulty' => 'Intermediate',
        'instructor' => 'Jessica Lee',
        'rating' => 4.8,
        'students' => 1956,
        'image' => '/placeholder.svg?height=200&width=350',
        'price' => 54.99,
        'description' => 'Master Figma to create stunning user interfaces and design systems for web and mobile.'
    ]
];

// Get unique categories, difficulty levels, and instructors for filters
$categories = array_unique(array_column($courses, 'category'));
$difficulties = array_unique(array_column($courses, 'difficulty'));
$instructors = array_unique(array_column($courses, 'instructor'));

// Handle search and filtering
$filtered_courses = $courses;
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$difficulty_filter = isset($_GET['difficulty']) ? $_GET['difficulty'] : '';
$instructor_filter = isset($_GET['instructor']) ? $_GET['instructor'] : '';

if (!empty($search_query)) {
    $filtered_courses = array_filter($filtered_courses, function($course) use ($search_query) {
        return stripos($course['title'], $search_query) !== false || 
               stripos($course['description'], $search_query) !== false;
    });
}

if (!empty($category_filter)) {
    $filtered_courses = array_filter($filtered_courses, function($course) use ($category_filter) {
        return $course['category'] === $category_filter;
    });
}

if (!empty($difficulty_filter)) {
    $filtered_courses = array_filter($filtered_courses, function($course) use ($difficulty_filter) {
        return $course['difficulty'] === $difficulty_filter;
    });
}

if (!empty($instructor_filter)) {
    $filtered_courses = array_filter($filtered_courses, function($course) use ($instructor_filter) {
        return $course['instructor'] === $instructor_filter;
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Discover Courses</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container">
        <section class="hero">
            <div class="hero-content">
                <h1>Expand Your Knowledge</h1>
                <p>Discover thousands of courses to help you grow personally and professionally.</p>
                <form action="" method="GET" class="search-form">
                    <div class="search-input-container">
                        <i data-feather="search" class="search-icon"></i>
                        <input type="text" name="search" placeholder="Search for courses..." value="<?php echo htmlspecialchars($search_query); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </section>

        <section class="course-section">
            <div class="filter-container">
                <div class="filter-header">
                    <h2>Filters</h2>
                    <button id="toggle-filters" class="btn-text">
                        <i data-feather="sliders"></i> Filters
                    </button>
                </div>
                
                <form id="filter-form" action="" method="GET" class="filters">
                    <?php if (!empty($search_query)): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                    <?php endif; ?>
                    
                    <div class="filter-group">
                        <h3>Category</h3>
                        <select name="category" class="filter-select">
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category); ?>" <?php echo $category_filter === $category ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Difficulty</h3>
                        <select name="difficulty" class="filter-select">
                            <option value="">All Levels</option>
                            <?php foreach ($difficulties as $difficulty): ?>
                                <option value="<?php echo htmlspecialchars($difficulty); ?>" <?php echo $difficulty_filter === $difficulty ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($difficulty); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Instructor</h3>
                        <select name="instructor" class="filter-select">
                            <option value="">All Instructors</option>
                            <?php foreach ($instructors as $instructor): ?>
                                <option value="<?php echo htmlspecialchars($instructor); ?>" <?php echo $instructor_filter === $instructor ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($instructor); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="index.php" class="btn btn-outline">Clear Filters</a>
                    </div>
                </form>
            </div>
            
            <div class="course-container">
                <div class="course-header">
                    <h2>Available Courses</h2>
                    <p><?php echo count($filtered_courses); ?> courses found</p>
                </div>
                
                <?php if (empty($filtered_courses)): ?>
                    <div class="no-results">
                        <i data-feather="search" class="no-results-icon"></i>
                        <h3>No courses found</h3>
                        <p>Try adjusting your search or filter criteria</p>
                        <a href="index.php" class="btn btn-primary">Clear all filters</a>
                    </div>
                <?php else: ?>
                    <div class="course-grid">
                        <?php foreach ($filtered_courses as $course): ?>
                            <div class="course-card">
                                <div class="course-image">
                                    <img src="<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                                    <div class="course-badge <?php echo strtolower($course['difficulty']); ?>">
                                        <?php echo htmlspecialchars($course['difficulty']); ?>
                                    </div>
                                </div>
                                <div class="course-content">
                                    <div class="course-category"><?php echo htmlspecialchars($course['category']); ?></div>
                                    <h3 class="course-title">
                                        <a href="course-detail.php?id=<?php echo $course['id']; ?>">
                                            <?php echo htmlspecialchars($course['title']); ?>
                                        </a>
                                    </h3>
                                    <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>
                                    <div class="course-meta">
                                        <div class="instructor">
                                            <i data-feather="user"></i>
                                            <span><?php echo htmlspecialchars($course['instructor']); ?></span>
                                        </div>
                                        <div class="rating">
                                            <i data-feather="star" class="star-filled"></i>
                                            <span><?php echo $course['rating']; ?> (<?php echo number_format($course['students']); ?> students)</span>
                                        </div>
                                    </div>
                                    <div class="course-footer">
                                        <div class="price"><?php echo '$' . number_format($course['price'], 2); ?></div>
                                        <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="btn btn-primary">View Course</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script>
        // Initialize Feather icons
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            
            // Toggle filters on mobile
            const toggleFiltersBtn = document.getElementById('toggle-filters');
            const filterForm = document.getElementById('filter-form');
            
            if (toggleFiltersBtn && filterForm) {
                toggleFiltersBtn.addEventListener('click', function() {
                    filterForm.classList.toggle('show');
                });
            }
        });
    </script>
</body>
</html>