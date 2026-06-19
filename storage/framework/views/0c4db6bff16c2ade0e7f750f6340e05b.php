<title><?php echo e($title); ?></title>

<meta name="description" content="<?php echo e($description); ?>">

<meta name="keywords" content="immobilier Côte d'Ivoire, maison à vendre, villa, terrain, appartement, location">


<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($description); ?>">
<meta property="og:image" content="<?php echo e($image); ?>">
<meta property="og:type" content="website">


<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($description); ?>">
<meta name="twitter:image" content="<?php echo e($image); ?>">


<script type="application/ld+json">
<?php
$schema = [
    "@context" => "https://schema.org",
    "@type" => "RealEstateAgent",
    "name" => "Sozo Habitat",
    "description" => "Agence immobilière spécialisée dans l'achat, la vente et la location de biens immobiliers en Côte d'Ivoire.",
    "image" => asset('images/logo.png'),
    "areaServed" => [
        "@type" => "Country",
        "name" => "Côte d'Ivoire"
    ],
    "url" => url('/')
];
?>

<?php echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>

</script><?php /**PATH D:\laragon\www\sozo-habitat\resources\views/components/seo.blade.php ENDPATH**/ ?>