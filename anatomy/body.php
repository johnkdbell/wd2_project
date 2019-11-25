       
        <?php $i = 0 ?>
        <?php while($i < count($project_blog_posts)): ?>   
        
        <div class="col-md-6 col-lg-4 col-xl-3 mx-auto">
            
            <!-- Creates posts/ Posts Previews -->
            <?php if ($i < 10): ?>
                
            <div class="post-preview">
                <!-- Posts Title-->
                <h1 class="post-title">
                    <a href="post.php?postID=<?= $project_blog_posts[$i]['postID'] ?>"><?= $project_blog_posts[$i]['postHeading'] ?></a>
                    <hr>
                </h1>
                
                <div>
                    <?php
                        $userQuery = "SELECT * FROM project_blog_users WHERE userID = ".$project_blog_posts[$i]['userID'];
                        $statement2 = $db->prepare($userQuery);
                        $statement2->execute();
                        $postUserID = $statement2->fetch();
                    ?>
                    <?= $postUserID['userLogin'] ?>
                </div>

                <div class="post-content">
                    <!-- Posts Checks Conent Size-->
                    <?php if (strip_tags(html_entity_decode(strlen($project_blog_posts[$i]['postContent']))) > 200): ?>
                        <?= cutContent($project_blog_posts, $i) ?>
                    
                    <!-- Posts Content-->
                    <?php else: ?>
                        <p>
                            <?= strip_tags(html_entity_decode($project_blog_posts[$i]['postContent'])) ?>
                        </p><br>
                    <?php endif ?>
                </div>

                <!-- Posts User and Date-->
                <p class="post-meta">
                    Posted on <?= date('M d Y, h:i:sa', strtotime($project_blog_posts[$i]['postDate'])) ?>                        
                </p>

                <!-- Posts Read Full/Edit-->
                <div class="post-read-edit">
                    <p>
                        <a href="post.php?postID=<?= $project_blog_posts[$i]['postID']?>">
                            Read Full Post</a>
                        
                        <?php if(!isset($_SESSION['user']['userID'])): ?>
                            
                        <?php elseif($_SESSION['user']['userID'] == $project_blog_posts[$i]['userID']): ?>
                            |
                        <a href="edit.php?postID=<?= $project_blog_posts[$i]['postID']?>">
                            Edit
                        </a>
                        
                        <?php endif; ?>

                        <?php
                            $commentQuery = "SELECT * FROM project_blog_comments WHERE postID = ".$project_blog_posts[$i]['postID'];
                            $statement3 = $db->prepare($commentQuery);
                            $statement3->execute();
                            $commentNumber = $statement3->fetchAll();
                        ?>

                        <p><?= count($commentNumber) ?> Comments</p>

                    </p>
                </div>
        
            </div>
                <?php $i++ ?>
        </div>
        
        <?php else: ?>
            <?php $i = count($project_blog_posts) ?>
        <?php endif ?>

        <?php endwhile ?> 


        