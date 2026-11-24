<?php
/**
 * The front page.
 *
 * The argument for the product, in the order a stranger needs it: what the vig
 * is and what removing it shows, what you get, how the record works, what it
 * costs. The live board sits high on the page when there is one, because the
 * fastest way to explain this site is to show it working.
 *
 * @package Antivig
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

get_header();

$antivig_has_board = false;

if ( class_exists( '\Antivig\Engine\Board\BoardPresenter' ) ) {
	$antivig_has_board = array() !== \Antivig\Engine\Board\BoardPresenter::upcoming( '', 2 );
}

$antivig_pricing = antivig_url( 'membership' );
$antivig_board   = antivig_url( 'today' );
$antivig_ledger  = antivig_url( 'ledger' );
?>

<main id="primary" class="site-main av-landing">

	<section class="av-hero">
		<div class="container av-hero__inner">

			<div class="av-hero__copy">
				<p class="av-eyebrow"><?php esc_html_e( 'Pregame analysis · NBA · NFL · MLB · WNBA', 'antivig-child' ); ?></p>

				<h1 class="av-hero__title"><?php esc_html_e( 'Know the fair price before you bet', 'antivig-child' ); ?></h1>

				<p class="av-hero__lede">
					<?php esc_html_e( 'Every sportsbook price has the house margin baked into it. Antivig takes it out, shows you what the game is really worth, and puts every pick we publish on a record that cannot be edited afterwards.', 'antivig-child' ); ?>
				</p>

				<p class="av-hero__actions">
					<a class="av-cta av-cta--primary" href="<?php echo esc_url( $antivig_board ); ?>">
						<?php esc_html_e( "See today's board", 'antivig-child' ); ?>
					</a>
					<a class="av-cta av-cta--ghost" href="<?php echo esc_url( $antivig_ledger ); ?>">
						<?php esc_html_e( 'Read the pick record', 'antivig-child' ); ?>
					</a>
				</p>

				<p class="av-hero__foot">
					<?php esc_html_e( 'No wagering. No balances. No prizes. 21+.', 'antivig-child' ); ?>
				</p>
			</div>

			<figure class="av-ticket" aria-label="<?php esc_attr_e( 'An example of the margin being removed', 'antivig-child' ); ?>">
				<figcaption class="av-ticket__tag"><?php esc_html_e( 'Example', 'antivig-child' ); ?></figcaption>

				<div class="av-ticket__row av-ticket__row--head">
					<span><?php esc_html_e( 'A typical moneyline', 'antivig-child' ); ?></span>
					<span class="av-ticket__vig"><?php esc_html_e( '3.6% margin', 'antivig-child' ); ?></span>
				</div>

				<div class="av-ticket__row">
					<span class="av-ticket__side"><?php esc_html_e( 'Favourite', 'antivig-child' ); ?></span>
					<span class="av-ticket__book">&minus;145</span>
					<span class="av-ticket__arrow" aria-hidden="true">&rarr;</span>
					<span class="av-ticket__fair">&minus;133</span>
				</div>

				<div class="av-ticket__row">
					<span class="av-ticket__side"><?php esc_html_e( 'Underdog', 'antivig-child' ); ?></span>
					<span class="av-ticket__book">+125</span>
					<span class="av-ticket__arrow" aria-hidden="true">&rarr;</span>
					<span class="av-ticket__fair">+133</span>
				</div>

				<p class="av-ticket__note">
					<?php esc_html_e( 'The book asks for 103.6% of the game. The fair price is what is left when you take the 3.6% back out — and it is the number every decision here is measured against.', 'antivig-child' ); ?>
				</p>
			</figure>

		</div>
	</section>

	<section class="av-section av-section--tight">
		<div class="container">
			<div class="av-grid av-grid--3">

				<article class="av-feature">
					<h2 class="av-feature__title"><?php esc_html_e( 'The fair price', 'antivig-child' ); ?></h2>
					<p><?php esc_html_e( "Each book's own margin comes off its own market — never one book's favourite against another's underdog, which describes a market that never existed. The result is a probability you can argue with.", 'antivig-child' ); ?></p>
				</article>

				<article class="av-feature">
					<h2 class="av-feature__title"><?php esc_html_e( 'The best number', 'antivig-child' ); ?></h2>
					<p><?php esc_html_e( 'The highest price on each side, which book is hanging it, and how long ago we saw it. A price nobody has confirmed in fifteen minutes is marked, not quietly shown.', 'antivig-child' ); ?></p>
				</article>

				<article class="av-feature">
					<h2 class="av-feature__title"><?php esc_html_e( 'The whole record', 'antivig-child' ); ?></h2>
					<p><?php esc_html_e( 'Every pick is timestamped before the game starts and chained to the one before it. Nothing can be deleted, back-dated or quietly improved — including by us.', 'antivig-child' ); ?></p>
				</article>

			</div>
		</div>
	</section>

	<?php if ( $antivig_has_board ) : ?>
		<section class="av-section">
			<div class="container">
				<header class="av-section__head">
					<h2 class="av-section__title"><?php esc_html_e( "Today's board", 'antivig-child' ); ?></h2>
					<a class="av-section__more" href="<?php echo esc_url( $antivig_board ); ?>"><?php esc_html_e( 'See every game', 'antivig-child' ); ?></a>
				</header>

				<?php echo do_shortcode( '[antivig_board limit="2"]' ); ?>
			</div>
		</section>
	<?php endif; ?>

	<section class="av-section av-section--dark">
		<div class="container">
			<header class="av-section__head av-section__head--center">
				<h2 class="av-section__title"><?php esc_html_e( 'How it works', 'antivig-child' ); ?></h2>
			</header>

			<ol class="av-steps">
				<li class="av-step">
					<span class="av-step__n">1</span>
					<h3 class="av-step__title"><?php esc_html_e( 'We watch the market', 'antivig-child' ); ?></h3>
					<p><?php esc_html_e( 'Prices are read from licensed feeds and stored only when they move — so the line history is a record of what actually happened, not of when a job last ran.', 'antivig-child' ); ?></p>
				</li>
				<li class="av-step">
					<span class="av-step__n">2</span>
					<h3 class="av-step__title"><?php esc_html_e( 'We take the margin out', 'antivig-child' ); ?></h3>
					<p><?php esc_html_e( 'Four methods, because they disagree on lopsided games and that disagreement is the favourite-longshot bias. You can see which one is being used.', 'antivig-child' ); ?></p>
				</li>
				<li class="av-step">
					<span class="av-step__n">3</span>
					<h3 class="av-step__title"><?php esc_html_e( 'We publish, then we are judged', 'antivig-child' ); ?></h3>
					<p><?php esc_html_e( 'A pick goes on the record before the game, and is settled against the closing line afterwards. The record shows the losers at the same size as the winners.', 'antivig-child' ); ?></p>
				</li>
			</ol>
		</div>
	</section>

	<section class="av-section">
		<div class="container av-promise">
			<div>
				<p class="av-eyebrow"><?php esc_html_e( 'The part most sites skip', 'antivig-child' ); ?></p>
				<h2 class="av-section__title"><?php esc_html_e( 'A record you can check yourself', 'antivig-child' ); ?></h2>
				<p>
					<?php esc_html_e( 'Every published pick carries a fingerprint of its own contents and of the pick before it. Change one old row and every row after it stops matching — which is what makes "we went 62% last month" something you can verify instead of something you have to believe.', 'antivig-child' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'It proves nothing was altered after the fact. It does not prove we published everything we thought — so we publish every pick we make, winners and losers, and show the open ones too.', 'antivig-child' ); ?>
				</p>
				<p>
					<a class="av-cta av-cta--ghost" href="<?php echo esc_url( $antivig_ledger ); ?>"><?php esc_html_e( 'Open the record', 'antivig-child' ); ?></a>
				</p>
			</div>

			<aside class="av-promise__aside">
				<p class="av-label"><?php esc_html_e( 'What we will never do', 'antivig-child' ); ?></p>
				<ul class="av-nots">
					<li><?php esc_html_e( 'Take a wager or hold your money', 'antivig-child' ); ?></li>
					<li><?php esc_html_e( 'Sell a "lock" or guarantee a result', 'antivig-child' ); ?></li>
					<li><?php esc_html_e( 'Quote a record we cannot show in full', 'antivig-child' ); ?></li>
					<li><?php esc_html_e( 'Publish a model pick before the model has beaten the closing line', 'antivig-child' ); ?></li>
				</ul>
			</aside>
		</div>
	</section>

	<section class="av-section av-section--cta">
		<div class="container av-final">
			<h2 class="av-section__title"><?php esc_html_e( 'Start with the free board', 'antivig-child' ); ?></h2>
			<p class="av-final__lede">
				<?php esc_html_e( 'Fair prices and the public record cost nothing — they are the argument. Membership adds value alerts and closing-line value. Model probabilities come only once a model has earned them.', 'antivig-child' ); ?>
			</p>
			<p class="av-hero__actions">
				<a class="av-cta av-cta--primary" href="<?php echo esc_url( $antivig_pricing ); ?>"><?php esc_html_e( 'See the plans', 'antivig-child' ); ?></a>
				<a class="av-cta av-cta--ghost" href="<?php echo esc_url( $antivig_board ); ?>"><?php esc_html_e( 'Browse the board first', 'antivig-child' ); ?></a>
			</p>
		</div>
	</section>

</main>

<?php
get_footer();
