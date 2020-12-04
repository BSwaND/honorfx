<?php

	defined('_JEXEC') or die;

	$myScript = true; // если "true" - то отключаем все стандатрные скрипты и подключаем свои (в том числе и jQuery)
	$app = JFactory::getApplication();
	$user = JFactory::getUser();
	$this->setHtml5(true);
	$params = $app->getTemplate(true)->params;
	$menu = $app->getMenu()->getActive();
	$document = JFactory::getDocument();
	$document->setGenerator('');
	$template_url = JUri::root() . 'template/' . $this->template;
	$pageclass = '';
	if (is_object($menu))
		$pageclass = $menu->params->get('pageclass_sfx');

	// Подключение своих стилей:
	JHtml::_('stylesheet', 'styles.min.css', array('version' => 'v=1.3', 'relative' => true));
	JHtml::_('stylesheet', 'custom.css', array('version' => 'v=1.1', 'relative' => true));

	if ($myScript) { // при необходимости отключаем все скрипты и подключаем свежий jQuery (параметр выше)
		$this->_scripts = array();
		unset($this->_script['text/javascript']);
		//JHtml::_('script', $template_url . '/js/jquery-3.3.1.min.js', array('version' => 'v=3.3.1'));
	}

	//Протокол Open Graph
	$pageTitle = $document->getTitle();
	$metaDescription = $document->getMetaData('description');
	$type = 'website';
	$view = $app->input->get('view', '');
	$id = $app->input->get('id', '');
	$image = JURI::base() . 'templates/custom/icon/logo.png';
	$title = !empty($pageTitle) ? $pageTitle : "default title";
	$desc = !empty($metaDescription) ? $metaDescription : "default description";

	if (!empty($view) && $view === 'article' && !empty($id)) {
		$article = JControllerLegacy::getInstance('Content')->getModel('Article')->getItem($id);
		$type = 'article';
		$images = json_decode($article->images);
		$image = !empty($images->image_intro) ? JURI::base() . $images->image_intro : JURI::base() . $images->image_fulltext;
	}
	$document->addCustomTag('
    <meta property="og:type" content="' . $type . '" />
    <meta property="og:title" content="' . $title . '" />
    <meta property="og:description" content="' . $desc . '" />
    <meta property="og:image" content="' . $image . '" />
    <meta property="og:url" content="' . JURI:: current() . '" />
');
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" prefix="og: http://ogp.me/ns#">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="/templates/<?php echo $this->template; ?>/icon/favicon.ico"/>
	<jdoc:include type="head"/>
</head>
<body class="<?php echo $pageclass ? htmlspecialchars($pageclass) : 'default'; ?>">

<header class="header">
	<div class="header_top-line">
		<div class="container">
			<div class="row">
				<div class="col-6">
					<a href="/" class="header_logo"><img src="images/logo.svg" alt="logo"></a>
				</div>
				<div class="col-6">
					<div class="header_control">
				      <span class="header_control__link-block">
					      <a href="#test-modal" class="header_control__link popup-modal">Client Login</a>
					      <a href="#test-modal" class="header_control__link popup-modal">IB Login</a>
				      </span>
						<span class="header_control__btn-hamburger">
					      <div class="hamburger">
						      <div class="hamburger-box">
							      <div class="hamburger-inner"></div>
						      </div>
					      </div>
				      </span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-9">
				<nav>
					<ul class="header_nav">
						<li class="active"><a href="#">Accounts</a></li>
						<li><a href="#">Market</a></li>
						<li><a href="#">Platform</a></li>
						<li><a href="#">Partnership</a></li>
						<li><a href="#">Tools</a></li>
						<li><a href="#">Education</a></li>
						<li><a href="#">Promotions</a></li>
					</ul>
				</nav>
			</div>
			<div class="col-3">
				<div class="header__btn_outer">
					<a href="#" class="btn header__btn"><span class="btn__inner">Open Live Account</span></a>
				</div>
			</div>
		</div>
	</div>
</header>


<jdoc:include type="component"/>


<footer class="footer">
	<div class="container">
		<a href="/" class="footer__logo"><img src="images/logo.svg" alt="logo"></a>
		<div class="footer_body">
			<div class="d-flex">
				<div class="footer_col-item-1">
					<div class="footer__descriptor">HonorFX is a brand name of Honor Capital Markets Limited. We are regulated by
						Financial Services Commission of the Republic of Mauritius with an Investment Dealer license. License number
						GB200225826.
					</div>
					<div class="footer_social">
						<a href="#" class="footer_social__link">
							<svg width="36" height="36" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
								<rect width="36" height="36" rx="18" fill="#9A9BAA"/>
								<path
										d="M21.3328 11.3333V11.3345H21.3332V14.0012H19.9998C19.5398 14.0012 19.3332 14.5404 19.3332 15.0012V16.6679H19.3332H21.3332V19.3345H19.3332V24.6679L16.6662 24.6666L16.6665 19.3345H14.6665V16.6679H16.6665L16.6666 14.0012C16.6666 12.5284 17.8604 11.3345 19.3332 11.3345L21.3328 11.3333Z"
										fill="#E6E6E6"/>
							</svg>
						</a>
						<a href="#" class="footer_social__link">
							<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="36" height="36" rx="18" fill="#9A9BAA"/>
								<path
										d="M23.3337 22.4445H20.9633V18.4445C20.9633 17.8172 20.2593 17.2924 19.632 17.2924C19.0047 17.2924 18.5929 17.8172 18.5929 18.4445V22.4445H16.2226V15.3334H18.5929V16.5186C18.9854 15.8837 19.9893 15.474 20.6818 15.474C22.1464 15.474 23.3337 16.6837 23.3337 18.1482V22.4445ZM15.0374 22.4445H12.667V15.3334H15.0374V22.4445ZM13.8522 11.7778C14.5067 11.7778 15.0374 12.3085 15.0374 12.963C15.0374 13.6176 14.5067 14.1482 13.8522 14.1482C13.1976 14.1482 12.667 13.6176 12.667 12.963C12.667 12.3085 13.1976 11.7778 13.8522 11.7778Z"
										fill="#E6E6E6"/>
							</svg>
						</a>
						<a href="#" class="footer_social__link">
							<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="36" height="36" rx="18" fill="#9A9BAA"/>
								<g clip-path="url(#clip0)">
									<path
											d="M23.3327 18.0001C23.3327 19.0717 23.3327 19.7945 23.3078 20.1932C23.2579 21.1652 22.9838 21.9129 22.4355 22.4362C21.8872 22.9596 21.1645 23.2586 20.1925 23.3085C19.7937 23.3334 19.0461 23.3334 17.9993 23.3334C16.9277 23.3334 16.205 23.3334 15.8062 23.3085C14.8342 23.2586 14.0866 22.9845 13.5632 22.4362C13.0398 21.9129 12.7408 21.1652 12.6909 20.1932C12.666 19.7945 12.666 19.0468 12.666 18.0001C12.666 16.9534 12.666 16.2057 12.6909 15.8069C12.7408 14.835 13.0149 14.0873 13.5632 13.5639C14.0866 13.0406 14.8342 12.7415 15.8062 12.6917C16.205 12.6667 16.9526 12.6667 17.9993 12.6667C19.071 12.6667 19.7937 12.6667 20.1925 12.6917C21.1645 12.7415 21.9121 13.0157 22.4355 13.5639C22.9588 14.1122 23.2579 14.835 23.3078 15.8069C23.3078 16.2057 23.3327 16.9284 23.3327 18.0001ZM18.5227 13.6138C18.1987 13.6138 18.0243 13.6138 17.9993 13.6138C17.9744 13.6138 17.8 13.6138 17.476 13.6138C17.152 13.6138 16.9028 13.6138 16.7532 13.6138C16.5788 13.6138 16.3545 13.6138 16.0803 13.6387C15.8062 13.6387 15.557 13.6636 15.3576 13.7135C15.1582 13.7384 14.9838 13.7882 14.8592 13.8381C14.6349 13.9378 14.4355 14.0624 14.2361 14.2368C14.0617 14.4113 13.937 14.6107 13.8374 14.8599C13.7875 14.9845 13.7377 15.159 13.7127 15.3583C13.6878 15.5577 13.6629 15.782 13.638 16.0811C13.638 16.3552 13.6131 16.5795 13.6131 16.754C13.6131 16.9284 13.6131 17.1777 13.6131 17.4767C13.6131 17.8007 13.6131 17.9752 13.6131 18.0001C13.6131 18.025 13.6131 18.1995 13.6131 18.5234C13.6131 18.8474 13.6131 19.0967 13.6131 19.2462C13.6131 19.4206 13.6131 19.6449 13.638 19.9191C13.638 20.1932 13.6629 20.4424 13.7127 20.6418C13.7626 20.8412 13.7875 21.0157 13.8374 21.1403C13.937 21.3646 14.0617 21.5639 14.2361 21.7633C14.4106 21.9378 14.6099 22.0624 14.8592 22.1621C14.9838 22.2119 15.1582 22.2618 15.3576 22.2867C15.557 22.3116 15.7813 22.3365 16.0803 22.3615C16.3794 22.3864 16.5788 22.3864 16.7532 22.3864C16.9277 22.3864 17.1769 22.3864 17.476 22.3864C17.8 22.3864 17.9744 22.3864 17.9993 22.3864C18.0243 22.3864 18.1987 22.3864 18.5227 22.3864C18.8467 22.3864 19.0959 22.3864 19.2455 22.3864C19.4199 22.3864 19.6442 22.3864 19.9184 22.3615C20.1925 22.3615 20.4417 22.3365 20.6411 22.2867C20.8405 22.2618 21.0149 22.2119 21.1395 22.1621C21.3638 22.0624 21.5632 21.9378 21.7626 21.7633C21.937 21.5889 22.0617 21.3895 22.1613 21.1403C22.2112 21.0157 22.261 20.8412 22.286 20.6418C22.3109 20.4424 22.3358 20.2181 22.3607 19.9191C22.3607 19.6449 22.3856 19.4206 22.3856 19.2462C22.3856 19.0717 22.3856 18.8225 22.3856 18.5234C22.3856 18.1995 22.3856 18.025 22.3856 18.0001C22.3856 17.9752 22.3856 17.8007 22.3856 17.4767C22.3856 17.1527 22.3856 16.9035 22.3856 16.754C22.3856 16.5795 22.3856 16.3552 22.3607 16.0811C22.3607 15.8069 22.3358 15.5577 22.286 15.3583C22.261 15.159 22.2112 14.9845 22.1613 14.8599C22.0617 14.6356 21.937 14.4362 21.7626 14.2368C21.5881 14.0624 21.3888 13.9378 21.1395 13.8381C21.0149 13.7882 20.8405 13.7384 20.6411 13.7135C20.4417 13.6886 20.2174 13.6636 19.9184 13.6387C19.6442 13.6387 19.4199 13.6138 19.2455 13.6138C19.0959 13.6138 18.8467 13.6138 18.5227 13.6138ZM19.9184 16.0562C20.4417 16.5795 20.7159 17.2275 20.7159 18.0001C20.7159 18.7727 20.4417 19.3957 19.9184 19.944C19.395 20.4674 18.747 20.7415 17.9744 20.7415C17.2018 20.7415 16.5788 20.4674 16.0305 19.944C15.5071 19.4206 15.233 18.7727 15.233 18.0001C15.233 17.2275 15.5071 16.6044 16.0305 16.0562C16.5539 15.5328 17.2018 15.2586 17.9744 15.2586C18.747 15.2586 19.395 15.5079 19.9184 16.0562ZM19.2455 19.2462C19.5944 18.8973 19.7688 18.4736 19.7688 18.0001C19.7688 17.5266 19.5944 17.078 19.2455 16.7291C18.8965 16.3801 18.4729 16.2057 17.9744 16.2057C17.476 16.2057 17.0523 16.3801 16.7034 16.7291C16.3545 17.078 16.18 17.5016 16.18 18.0001C16.18 18.4985 16.3545 18.9222 16.7034 19.2462C17.0523 19.5951 17.476 19.7696 17.9744 19.7696C18.4729 19.7696 18.8965 19.5951 19.2455 19.2462ZM21.2891 14.6854C21.4137 14.8101 21.4884 14.9596 21.4884 15.134C21.4884 15.3085 21.4137 15.458 21.2891 15.5826C21.1645 15.7072 21.0149 15.782 20.8405 15.782C20.666 15.782 20.5165 15.7072 20.3919 15.5826C20.2673 15.458 20.1925 15.3085 20.1925 15.134C20.1925 14.9596 20.2673 14.8101 20.3919 14.6854C20.5165 14.5608 20.666 14.4861 20.8405 14.4861C21.0149 14.4861 21.1645 14.5608 21.2891 14.6854Z"
											fill="#E6E6E6"/>
								</g>
								<defs>
									<clipPath id="clip0">
										<rect width="16" height="16" fill="white" transform="translate(10 10)"/>
									</clipPath>
								</defs>
							</svg>
						</a>
						<a href="#" class="footer_social__link">
							<svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="36" height="36" rx="18" fill="#9A9BAA"/>
								<path
										d="M24.973 14.0083C24.4599 14.2359 23.9084 14.3897 23.3298 14.4588C23.9204 14.1048 24.3741 13.5441 24.5877 12.8759C24.0348 13.2038 23.4226 13.4419 22.7708 13.5702C22.249 13.0142 21.5054 12.6667 20.6825 12.6667C19.1024 12.6667 17.8213 13.9477 17.8213 15.5278C17.8213 15.752 17.8466 15.9704 17.8954 16.1798C15.5176 16.0605 13.4093 14.9214 11.9982 13.1904C11.7519 13.613 11.6108 14.1045 11.6108 14.6288C11.6108 15.6214 12.1159 16.4972 12.8837 17.0103C12.4147 16.9953 11.9735 16.8667 11.5878 16.6524C11.5875 16.6643 11.5875 16.6763 11.5875 16.6883C11.5875 18.0746 12.5737 19.2309 13.8826 19.4938C13.6425 19.5592 13.3897 19.5942 13.1288 19.5942C12.9444 19.5942 12.7652 19.5762 12.5905 19.5429C12.9546 20.6795 14.0112 21.5067 15.2632 21.5297C14.284 22.2972 13.0503 22.7546 11.7099 22.7546C11.4789 22.7546 11.2512 22.741 11.0273 22.7145C12.2935 23.5263 13.7974 24.0001 15.4132 24.0001C20.6758 24.0001 23.5536 19.6404 23.5536 15.8595C23.5536 15.7355 23.5508 15.6121 23.5453 15.4894C24.1044 15.086 24.5894 14.5821 24.973 14.0083Z"
										fill="#E6E6E6"/>
							</svg>
						</a>
						<a href="#" class="footer_social__link">
							<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect width="38" height="38" rx="19" fill="#9A9BAA"/>
								<g clip-path="url(#clip0)">
									<path
											d="M26.191 14.8776C26.0181 14.1435 25.5115 13.5647 24.869 13.3671C23.6952 13 19 13 19 13C19 13 14.3048 13 13.131 13.3529C12.5008 13.5506 11.9819 14.1435 11.8089 14.8776C11.5 16.2188 11.5 19 11.5 19C11.5 19 11.5 21.7953 11.8089 23.1224C11.9819 23.8565 12.4885 24.4353 13.131 24.6329C14.3171 25 19 25 19 25C19 25 23.6952 25 24.869 24.6471C25.5115 24.4494 26.0181 23.8706 26.191 23.1365C26.4999 21.7953 26.4999 19.0141 26.4999 19.0141C26.4999 19.0141 26.5123 16.2188 26.191 14.8776Z"
											fill="#E6E6E6"/>
									<path d="M21.4093 19.0001L17.5049 16.4307V21.5695L21.4093 19.0001Z" fill="#9A9BAA"/>
								</g>
								<defs>
									<clipPath id="clip0">
										<rect width="15" height="12" fill="white" transform="translate(11.5 13)"/>
									</clipPath>
								</defs>
							</svg>
						</a>
					</div>
				</div>
				<div class="footer_col-item-2">
					<div class="footer__info"><b>Risk Warning: </b>Trading Forex and Leveraged Financial Instruments involves
						significant risk and can result in the loss of your invested capital. You should not invest more than you
						can afford to lose and should ensure that you fully understand the risks involved. Trading leveraged
						products may not be suitable for all investors.Past performance is no guarantee of future results.It is the
						responsibility of the Client to ascertain whether he/she is permitted to use the services of the Honorfx
						brand based on the legal requirements in his/her country of residence. Please read Honorfx’s full Risk
						Disclosure. Regional restrictions: Honorfx brand does not provide services to residents of the USA, Japan,
						British Columbia, Mauritius, Quebec and FATF black listed countries. Find out more in the Regulations
						section of our FAQs.
					</div>
				</div>
				<div class="footer_col-item-3">
					<div class="footer_address">
						<div class="footer_address_item">
							<img src="images/marker.svg" class="footer_address__marker">
							<span
									class="footer_address__text">10th Floor, Sterling Tower, 14 Poudriere Street, Port Louis, Mauritius</span>
						</div>
						<div class="footer_address_item">
							<img src="images/phone.svg" class="footer_address__marker">
							<span class="footer_address__text">+442032396011</span>
						</div>
						<div class="footer_address_item">
							<img src="images/mail.svg" class="footer_address__marker">
							<span class="footer_address__text">support@honorfx.com</span>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer_sub">
		<div class="container">
			<div class="row">
				<div class="offset-ss-1 col-ss-10">
					<a href="#" class="footer_link"><b>Refund and Return Policy</b> </a>
					<a href="#" class="footer_link"> Website Terms & Conditions</a>
					<a href="#" class="footer_link">Anti-Money Laundering Policy</a>
					<a href="#" class="footer_link">Regulations Legal Documents</a>
					<a href="#" class="footer_link">Important Information</a>
					<a href="#" class="footer_link">Customer Agreement </a>
					<a href="#" class="footer_link">Risk Disclosure</a>
					<a href="#" class="footer_link">Privacy Policy</a>
					<a href="#" class="footer_link">Orders Policy</a>
				</div>
			</div>
		</div>
	</div>
</footer>

<div class="btn-up">
	<svg width="26" height="14" viewBox="0 0 26 14" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path
				d="M11.8748 0.309078L0.308338 11.8755C-0.102779 12.2866 -0.102779 12.9512 0.308338 13.3623C0.719456 13.7734 1.38402 13.7734 1.79513 13.3623L12.6182 2.53929L23.4412 13.3623C23.8523 13.7734 24.5169 13.7734 24.928 13.3623C25.133 13.1573 25.2361 12.8881 25.2361 12.6189C25.2361 12.3497 25.133 12.0805 24.928 11.8755L13.3615 0.309028C12.9505 -0.10204 12.2859 -0.102039 11.8748 0.309078Z"
				fill="white"/>
	</svg>
</div>


<div id="test-modal" class="mfp-hide white-popup-block">
	<a class="popup-modal-dismiss" href="#">x</a>

	<div class="white-popup-block_body">
		<div class="products_section">
			<div class="tab_section">
				<div class="tab_btn-block">
					<div class="btn tab_btn active">Registration</div>
					<div class="btn tab_btn">Log In</div>
				</div>

				<div class="tab_window">
					<form action="" class="reg-form">
						<label>
							<span>Name</span>
							<input class="reg-form__input" type="text" name="" placeholder="Full Name..">
						</label>
						<label>
							<span>Email</span>
							<input class="reg-form__input" type="text" name="" placeholder="Email..">
						</label>
						<label>
							<span>Country</span>
							<select name="country">
								<option value="">United Arab Emirates</option>
								<option value="">Berlin</option>
								<option value="">China</option>
							</select>
						</label>
						<label class="mobail_outer">
							<span>Mobile Number</span>
							<select name="mobile_code">
								<option value="">(+971)</option>
								<option value="">(+972)</option>
								<option value="">(+973)</option>
							</select>
							<input class="reg-form__input mobil_tel" type="text" name="" placeholder="">
						</label>
						<label>
							<span>Password</span>
							<input class="reg-form__input" type="password" name="" placeholder="Password">
						</label>

						<div class="reg-form__radio_outer">
							<label for="reg-form__radio" class="reg-form__radio_label">
								<input class="reg-form__radio" id="reg-form__radio" type="radio" name="">
							</label>
							<span>I agree with the <b>Terms of User</b></span>
						</div>

						<input type="submit" class="btn btn_blue" value="REGISTER">
					</form>
				</div>


				<div class="tab_window">
					<form action="" class="login-form">
						<label>
							<span>Email</span>
							<input class="reg-form__input" type="text" name="" placeholder="Email..">
						</label>

						<label>
							<span>Password</span>
							<input class="reg-form__input" type="password" name="" placeholder="Password">
						</label>

						<div class="reg-form__radio_outer">
							<label for="reg-form__radio1" class="reg-form__radio_label">
								<input class="reg-form__radio" id="reg-form__radio1" type="radio" name="">
							</label>
							<span>Remember me</span>

							<div class="link__forgot-password"><a href="#">Forgot password?</a></div>
						</div>


						<input type="submit" class="btn btn_blue" value="LOGIN">

						<div class="text-center mt-3 mb-3">
							<div class="">
								Not registreted? <a href="#"><b>Create an account</b></a>
							</div>
						</div>

					</form>
					<div class="login-form__after_block">
						<div class="login-form__after_text">Trade <br>with<br> Honor</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/templates/<?php echo $this->template; ?>/js/scripts.min.js"></script> 

</body>
</html>