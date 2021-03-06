<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 */

$enc = $this->encoder();
$productItems = $this->get( 'boughtItems', array() );

$detailTarget = $this->config( 'client/html/catalog/detail/url/target' );
$detailController = $this->config( 'client/html/catalog/detail/url/controller', 'catalog' );
$detailAction = $this->config( 'client/html/catalog/detail/url/action', 'detail' );
$detailConfig = $this->config( 'client/html/catalog/detail/url/config', array() );

?>
<?php $this->block()->start( 'basket/related/bought' ); ?>
<?php if( !empty( $productItems ) || $this->boughtBody != '' ) : ?>
<section class="basket-related-bought">
	<h2 class="header"><?php echo $this->translate( 'client', 'Products you might be also interested in' ); ?></h2>
	<ul class="bought-items">
<?php	foreach( $productItems as $id => $productItem ) : ?>
		<li class="bought-item" itemscope="" itemtype="http://schema.org/Product">
<?php		$params = array( 'd_name' => $productItem->getName( 'url' ), 'd_prodid' => $productItem->getId() ); ?>
			<a href="<?php echo $enc->attr( $this->url( $detailTarget, $detailController, $detailAction, $params, array(), $detailConfig ) ); ?>">
<?php		$mediaItems = $productItem->getRefItems( 'media', 'default', 'default' ); ?>
<?php		if( ( $mediaItem = reset( $mediaItems ) ) !== false ) : ?>
<?php			$mediaUrl = $enc->attr( $this->content( $mediaItem->getPreview() ) ); ?>
				<div class="media-item" style="background-image: url('<?php echo $mediaUrl; ?>')" itemscope="" itemtype="http://schema.org/ImageObject">
					<meta itemprop="contentUrl" content="<?php echo $mediaUrl; ?>" />
				</div>
<?php		else : ?>
				<div class="media-item"></div>
<?php		endif; ?>
				<h3 class="name" itemprop="name"><?php echo $enc->html( $productItem->getName(), $enc::TRUST ); ?></h3>
				<div class="price-list" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
<?php		echo $this->partial( $this->config( 'client/html/common/partials/price', 'common/partials/price-default.php' ), array( 'prices' => $productItem->getRefItems( 'price', null, 'default' ) ) ); ?>
				</div>
			</a>
		</li>
<?php	endforeach; ?>
	</ul>
<?php echo $this->boughtBody; ?>
</section>
<?php endif; ?>
<?php $this->block()->stop(); ?>
<?php echo $this->block()->get( 'basket/related/bought' ); ?>
