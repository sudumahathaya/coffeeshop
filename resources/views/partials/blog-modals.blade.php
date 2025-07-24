<!-- resources/views/partials/blog-modals.blade.php -->

<!-- Featured Article Modal -->
<div class="modal fade" id="articleModal1" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-coffee">
                    <i class="bi bi-cup-hot me-2"></i>The Art of Perfect Espresso
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&h=400&fit=crop"
                     class="img-fluid rounded mb-4" alt="Perfect Espresso">

                <div class="article-meta mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="avindu.jpg"
                                 class="rounded-circle me-3" width="50" height="50" alt="Author">
                            <div>
                                <h6 class="mb-0">Avindu Oshan</h6>
                                <small class="text-muted">Head Barista • December 15, 2024</small>
                            </div>
                        </div>
                        <span class="badge bg-info">Brewing Guide</span>
                    </div>
                </div>

                <div class="article-content">
                    <p class="lead">Espresso is the foundation of countless coffee drinks, yet mastering it requires understanding the delicate balance of grind, dose, time, and pressure.</p>

                    <h6 class="text-coffee mt-4 mb-3">The Perfect Grind</h6>
                    <p>Start with a fine, consistent grind. The particles should feel like powdered sugar between your fingers. Too coarse, and the water will flow too quickly, resulting in sour, under-extracted espresso. Too fine, and you'll get a bitter, over-extracted shot.</p>

                    <h6 class="text-coffee mt-4 mb-3">Dosing and Distribution</h6>
                    <p>Use 18-20 grams of coffee for a double shot. Distribute the grounds evenly in the portafilter before tamping. This ensures uniform water flow and extraction.</p>

                    <h6 class="text-coffee mt-4 mb-3">The Golden Ratio</h6>
                    <p>Aim for a 1:2 ratio - 18g of coffee should yield 36g of espresso in 25-30 seconds. This creates the perfect balance of flavor compounds.</p>

                    <div class="alert alert-info mt-4">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Pro Tip:</strong> Fresh beans are crucial. Use coffee roasted within 2-3 weeks for optimal flavor extraction.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee like-btn">
                    <i class="bi bi-heart me-2"></i>Like Article
                </button>
            </div>
        </div>
    </div>
</div>

<!-- French Press Modal -->
<div class="modal fade" id="articleModal2" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-coffee">
                    <i class="bi bi-cup me-2"></i>Mastering the French Press
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=800&h=400&fit=crop"
                     class="img-fluid rounded mb-4" alt="French Press">

                <div class="article-meta mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop&crop=face"
                                 class="rounded-circle me-3" width="50" height="50" alt="Author">
                            <div>
                                <h6 class="mb-0">Nimal Perera</h6>
                                <small class="text-muted">Senior Barista • December 10, 2024</small>
                            </div>
                        </div>
                        <span class="badge bg-info">Brewing Guide</span>
                    </div>
                </div>

                <div class="article-content">
                    <p class="lead">The French press, also known as cafetière, is one of the most forgiving and rewarding methods to brew coffee at home.</p>

                    <h6 class="text-coffee mt-4 mb-3">What You'll Need</h6>
                    <ul>
                        <li>French press (350ml capacity recommended)</li>
                        <li>Coarse ground coffee (30g for 500ml water)</li>
                        <li>Hot water (95°C)</li>
                        <li>Timer</li>
                        <li>Stirring spoon</li>
                    </ul>

                    <h6 class="text-coffee mt-4 mb-3">Step-by-Step Process</h6>
                    <ol>
                        <li><strong>Preheat:</strong> Rinse the French press with hot water</li>
                        <li><strong>Add coffee:</strong> Add coarse ground coffee to the bottom</li>
                        <li><strong>Bloom:</strong> Pour a small amount of water, stir, wait 30 seconds</li>
                        <li><strong>Fill:</strong> Add remaining water, stir once more</li>
                        <li><strong>Steep:</strong> Place lid on, wait 4 minutes</li>
                        <li><strong>Plunge:</strong> Press down slowly and serve immediately</li>
                    </ol>

                    <div class="alert alert-success mt-4">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Result:</strong> Rich, full-bodied coffee with all the natural oils and flavors intact.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee share-btn">
                    <i class="bi bi-share me-2"></i>Share Article
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Ceylon Coffee History Modal -->
<div class="modal fade" id="articleModal3" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-coffee">
                    <i class="bi bi-globe-asia-australia me-2"></i>Ceylon Coffee: A Rich Heritage
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&h=400&fit=crop"
                     class="img-fluid rounded mb-4" alt="Ceylon Coffee">

                <div class="article-meta mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=50&h=50&fit=crop&crop=face"
                                 class="rounded-circle me-3" width="50" height="50" alt="Author">
                            <div>
                                <h6 class="mb-0">Sasha Fernando</h6>
                                <small class="text-muted">Coffee Historian • December 8, 2024</small>
                            </div>
                        </div>
                        <span class="badge bg-success">Coffee Culture</span>
                    </div>
                </div>

                <div class="article-content">
                    <p class="lead">Sri Lanka's coffee history is a tale of triumph, devastation, and resilience that shaped the island's agricultural landscape forever.</p>

                    <h6 class="text-coffee mt-4 mb-3">The Golden Era (1860s-1870s)</h6>
                    <p>Ceylon coffee was once considered among the world's finest. The British colonial administration developed extensive coffee plantations in the central highlands, making coffee the island's primary export crop.</p>

                    <h6 class="text-coffee mt-4 mb-3">The Great Devastation</h6>
                    <p>In the 1870s, a devastating fungal disease called coffee leaf rust (Hemileia vastatrix) swept through the plantations, destroying the industry almost overnight. This catastrophe led to the transition to tea cultivation.</p>

                    <h6 class="text-coffee mt-4 mb-3">Modern Revival</h6>
                    <p>Today, Sri Lankan coffee is making a comeback. Small-scale farmers in regions like Kandy, Badulla, and Ratnapura are producing specialty coffee beans that are gaining international recognition.</p>

                    <blockquote class="blockquote text-center mt-4">
                        <p class="mb-0">"Ceylon coffee represents the resilience of our people and the richness of our soil."</p>
                        <footer class="blockquote-footer mt-2">Dr. Rohana Wijekoon, <cite title="Ceylon Coffee Research Institute">Ceylon Coffee Research Institute</cite></footer>
                    </blockquote>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('menu') }}" class="btn btn-coffee" data-bs-dismiss="modal">
                    <i class="bi bi-cup-hot me-2"></i>Try Our Ceylon Coffee
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Cold Brew Recipe Modal -->
<div class="modal fade" id="articleModal4" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-coffee">
                    <i class="bi bi-snow2 me-2"></i>Ultimate Cold Brew Recipe
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=800&h=400&fit=crop"
                     class="img-fluid rounded mb-4" alt="Cold Brew">

                <div class="article-meta mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop&crop=face"
                                 class="rounded-circle me-3" width="50" height="50" alt="Author">
                            <div>
                                <h6 class="mb-0">Kavya Rajapaksha</h6>
                                <small class="text-muted">Beverage Specialist • December 5, 2024</small>
                            </div>
                        </div>
                        <span class="badge bg-warning">Recipe</span>
                    </div>
                </div>

                <div class="article-content">
                    <p class="lead">Perfect for Sri Lanka's tropical climate, this cold brew recipe delivers smooth, refreshing coffee that's low in acidity and high in flavor.</p>

                    <h6 class="text-coffee mt-4 mb-3">Ingredients</h6>
                    <ul>
                        <li>1 cup coarsely ground coffee (preferably medium-dark roast)</li>
                        <li>4 cups cold, filtered water</li>
                        <li>Large jar or French press</li>
                        <li>Fine mesh strainer or cheesecloth</li>
                    </ul>

                    <h6 class="text-coffee mt-4 mb-3">Instructions</h6>
                    <ol>
                        <li><strong>Combine:</strong> Mix coffee and water in a large jar</li>
                        <li><strong>Steep:</strong> Let sit at room temperature for 12-24 hours</li>
                        <li><strong>Strain:</strong> Filter through fine mesh or cheesecloth</li>
                        <li><strong>Store:</strong> Refrigerate concentrate for up to 2 weeks</li>
                        <li><strong>Serve:</strong> Dilute 1:1 with water or milk over ice</li>
                    </ol>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="alert alert-primary">
                                <h6><i class="bi bi-thermometer-low me-2"></i>Serving Suggestions</h6>
                                <ul class="mb-0 small">
                                    <li>Add coconut milk for tropical twist</li>
                                    <li>Mix with condensed milk Lankan-style</li>
                                    <li>Serve with palm sugar syrup</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <h6><i class="bi bi-clock-history me-2"></i>Pro Tips</h6>
                                <ul class="mb-0 small">
                                    <li>Use a 1:4 coffee to water ratio</li>
                                    <li>Coarse grind prevents over-extraction</li>
                                    <li>Longer steeping = stronger concentrate</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee" onclick="printRecipe()">
                    <i class="bi bi-printer me-2"></i>Print Recipe
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Additional Article Modals -->
<div class="modal fade" id="articleModal5" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-coffee">
                    <i class="bi bi-star me-2"></i>Introducing Our New Signature Blend
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=800&h=400&fit=crop"
                     class="img-fluid rounded mb-4" alt="New Blend">

                <div class="article-content">
                    <p class="lead">We're thrilled to announce the launch of "Elixir Harmony" - our newest signature blend that represents the perfect marriage of three distinct coffee origins.</p>

                    <h6 class="text-coffee mt-4 mb-3">The Blend Profile</h6>
                    <p>Elixir Harmony combines Ethiopian Yirgacheffe for brightness, Colombian Huila for body, and a touch of Indian Monsooned Malabar for earthiness. The result is a complex yet balanced cup with notes of citrus, chocolate, and warm spices.</p>

                    <h6 class="text-coffee mt-4 mb-3">Perfect For</h6>
                    <ul>
                        <li>Morning espresso with bright acidity</li>
                        <li>Afternoon filter coffee with milk</li>
                        <li>French press for full body experience</li>
                    </ul>

                    <div class="alert alert-success mt-4">
                        <i class="bi bi-gift me-2"></i>
                        <strong>Launch Special:</strong> Try Elixir Harmony for Rs. 450 (regular Rs. 520) until December 31st!
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('menu') }}" class="btn btn-coffee" data-bs-dismiss="modal">
                    <i class="bi bi-cup-hot me-2"></i>Order Now
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Health Benefits Modal -->
<div class="modal fade" id="articleModal6" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-coffee">
                    <i class="bi bi-heart-pulse me-2"></i>Health Benefits of Quality Coffee
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=800&h=400&fit=crop"
                     class="img-fluid rounded mb-4" alt="Coffee Health">

                <div class="article-content">
                    <p class="lead">Beyond its delicious taste, quality coffee offers numerous health benefits when consumed in moderation as part of a balanced lifestyle.</p>

                    <h6 class="text-coffee mt-4 mb-3">Antioxidant Powerhouse</h6>
                    <p>Coffee is one of the richest sources of antioxidants in the Western diet. These compounds help protect your cells from damage caused by free radicals.</p>

                    <h6 class="text-coffee mt-4 mb-3">Cognitive Benefits</h6>
                    <p>Caffeine can improve mental alertness, concentration, and memory formation. Regular coffee consumption has been linked to reduced risk of neurodegenerative diseases.</p>

                    <h6 class="text-coffee mt-4 mb-3">Physical Performance</h6>
                    <p>Caffeine increases adrenaline levels and releases fatty acids from fat tissues, making it an excellent pre-workout beverage.</p>

                    <div class="alert alert-warning mt-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Moderation is Key:</strong> Limit intake to 3-4 cups per day and avoid adding excessive sugar or cream.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee like-btn">
                    <i class="bi bi-heart me-2"></i>Like Article
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Latte Art Modal -->
<div class="modal fade" id="articleModal7" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-coffee">
                    <i class="bi bi-palette me-2"></i>Latte Art for Beginners
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=400&fit=crop"
                     class="img-fluid rounded mb-4" alt="Latte Art">

                <div class="article-content">
                    <p class="lead">Transform your home coffee experience by learning the basics of latte art. With practice and patience, you'll be creating beautiful designs in no time.</p>

                    <h6 class="text-coffee mt-4 mb-3">Essential Equipment</h6>
                    <ul>
                        <li>Espresso machine with steam wand</li>
                        <li>Milk frothing pitcher (stainless steel)</li>
                        <li>Fresh, cold milk (whole milk works best)</li>
                        <li>6oz coffee cups</li>
                    </ul>

                    <h6 class="text-coffee mt-4 mb-3">Basic Technique</h6>
                    <ol>
                        <li><strong>Steam the milk:</strong> Create microfoam with velvety texture</li>
                        <li><strong>Pour height:</strong> Start high, finish low</li>
                        <li><strong>Cup angle:</strong> Tilt the cup 45 degrees</li>
                        <li><strong>Flow control:</strong> Steady, controlled pour</li>
                    </ol>

                    <h6 class="text-coffee mt-4 mb-3">Beginner Patterns</h6>
                    <ul>
                        <li><strong>Heart:</strong> Pour in center, then draw through</li>
                        <li><strong>Leaf:</strong> Side-to-side motion, finish with line</li>
                        <li><strong>Tulip:</strong> Multiple hearts stacked vertically</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-coffee share-btn">
                    <i class="bi bi-share me-2"></i>Share Tutorial
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function printRecipe() {
    const content = document.querySelector('#articleModal4 .article-content').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Cold Brew Recipe - Café Elixir</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                    h1 { color: #8B4513; border-bottom: 2px solid #8B4513; padding-bottom: 10px; }
                    h6 { color: #8B4513; margin-top: 20px; font-size: 16px; }
                    .alert { padding: 15px; margin: 15px 0; border-radius: 5px; }
                    .alert-primary { background: #e3f2fd; border-left: 4px solid #2196f3; }
                    .alert-success { background: #e8f5e8; border-left: 4px solid #4caf50; }
                    ul, ol { padding-left: 20px; }
                    li { margin-bottom: 5px; }
                    .row { display: flex; gap: 20px; }
                    .col-md-6 { flex: 1; }
                    @media print { .no-print { display: none; } }
                </style>
            </head>
            <body>
                <h1>Ultimate Cold Brew Recipe</h1>
                <p><strong>From Café Elixir Blog</strong> | <em>Perfect for Sri Lanka's tropical climate</em></p>
                ${content}
                <hr style="margin-top: 30px;">
                <p><small>© 2024 Café Elixir. Visit us at 123 Galle Road, Colombo 03</small></p>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Enhanced modal functionality
document.addEventListener('DOMContentLoaded', function() {
    // Like button functionality
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                this.classList.remove('btn-coffee');
                this.classList.add('btn-danger');
                this.innerHTML = '<i class="bi bi-heart-fill me-2"></i>Liked!';
                showNotification('Article liked! ❤️', 'success');
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                this.classList.remove('btn-danger');
                this.classList.add('btn-coffee');
                this.innerHTML = '<i class="bi bi-heart me-2"></i>Like Article';
                showNotification('Article unliked', 'info');
            }
        });
    });

    // Share button functionality
    document.querySelectorAll('.share-btn').forEach(button => {
        button.addEventListener('click', function() {
            const modalTitle = this.closest('.modal').querySelector('.modal-title').textContent.trim();

            if (navigator.share) {
                navigator.share({
                    title: modalTitle,
                    text: 'Check out this article from Café Elixir Blog',
                    url: window.location.href
                });
            } else {
                // Fallback for browsers without Web Share API
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    showNotification('Article link copied to clipboard!', 'success');
                }).catch(() => {
                    showNotification('Sharing functionality coming soon!', 'info');
                });
            }
        });
    });

    // Modal view tracking (simulation)
    document.querySelectorAll('[data-bs-target*="articleModal"]').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-bs-target');
            const articleTitle = this.closest('.blog-card').querySelector('.blog-title').textContent;
            console.log(`Article viewed: ${articleTitle}`);

            // Simulate view count increment
            setTimeout(() => {
                const viewCount = this.closest('.blog-card').querySelector('.bi-eye').nextSibling;
                if (viewCount && viewCount.textContent) {
                    const currentViews = parseInt(viewCount.textContent.replace(/[^\d]/g, ''));
                    viewCount.textContent = (currentViews + 1).toLocaleString();
                }
            }, 1000);
        });
    });
});
</script>
