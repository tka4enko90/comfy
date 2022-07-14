<?php /* Template Name: Coming Soon */
wp_enqueue_style( 'coming-soon', get_template_directory_uri() . '/dist/css/pages/coming-soon.css', '', '', 'all' );

$page = array(
	'image_id' => get_post_thumbnail_id(),
	'content'  => get_field( 'content' ),
);

get_header();
?>
<main class="main">
	<section class="section coming-soon-section">
		<div class="container container-lg">
			<div class="row">
				<div class="col">
					<?php echo ! empty( $page['image_id'] ) ? wp_get_attachment_image( $page['image_id'], 'cmf_coming_soon' ) : ''; ?>
				</div>
				<div class="col">
					<div class="section-content-wrap">
						<div class="logo">
							<svg width="144" height="50" viewBox="0 0 114 40" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.66418 30.8915C8.14335 30.8915 6.78497 30.6606 5.58905 30.1987C4.39312 29.7368 3.38039 29.078 2.55085 28.2221C1.7213 27.3663 1.08878 26.3339 0.653265 25.1248C0.217755 23.9158 0 22.5709 0 21.0902C0 19.3921 0.273058 17.8706 0.819174 16.5257C1.36529 15.1809 2.12916 14.0466 3.11079 13.1228C4.09241 12.199 5.25723 11.4926 6.60524 11.0036C7.95325 10.5145 9.43606 10.27 11.0537 10.27C12.1736 10.27 13.1967 10.4025 14.123 10.6674C15.0493 10.9323 15.8443 11.2991 16.5079 11.7677C17.1716 12.2364 17.6866 12.8002 18.0529 13.459C18.4193 14.1179 18.6025 14.8345 18.6025 15.6088C18.6025 16.1386 18.5196 16.6174 18.3537 17.0454C18.1877 17.4733 17.9631 17.8401 17.6796 18.1457C17.3962 18.4514 17.0679 18.6891 16.6946 18.8589C16.3213 19.0287 15.9203 19.1136 15.4917 19.1136C14.3165 19.1136 13.4628 18.774 12.9305 18.0948C12.3982 17.4155 12.1321 16.3559 12.1321 14.916C12.1321 14.1688 12.1182 13.5473 12.0906 13.0515C12.0629 12.5556 12.0007 12.1583 11.9039 11.8594C11.8072 11.5606 11.6758 11.35 11.5099 11.2277C11.344 11.1055 11.1228 11.0443 10.8463 11.0443C10.3624 11.0443 9.92687 11.2481 9.53975 11.6557C9.15263 12.0632 8.82427 12.6168 8.55467 13.3164C8.28507 14.016 8.08114 14.8379 7.94288 15.782C7.80462 16.7261 7.73549 17.728 7.73549 18.7876C7.73549 23.9498 9.65727 26.5308 13.5008 26.5308C14.6622 26.5308 15.6749 26.2727 16.539 25.7565C17.4031 25.2403 18.0979 24.5747 18.6233 23.7596L18.9551 23.9837C18.7339 25.0569 18.3606 26.0214 17.8352 26.8773C17.3098 27.7331 16.6531 28.4565 15.865 29.0474C15.077 29.6383 14.161 30.0934 13.1172 30.4127C12.0733 30.7319 10.9223 30.8915 9.66418 30.8915Z" fill="#283455"/>
								<path d="M31.2113 30.8915C29.4416 30.8915 27.8828 30.6504 26.5348 30.1681C25.1868 29.6859 24.06 29.0066 23.1544 28.1304C22.2488 27.2542 21.5679 26.1912 21.1116 24.9414C20.6554 23.6917 20.4272 22.306 20.4272 20.7845C20.4272 19.1272 20.7003 17.6465 21.2464 16.3424C21.7925 15.0382 22.553 13.9379 23.5277 13.0413C24.5024 12.1447 25.6603 11.4587 27.0014 10.9832C28.3425 10.5078 29.808 10.27 31.398 10.27C33.1677 10.27 34.723 10.5111 36.0641 10.9934C37.4052 11.4757 38.5286 12.1549 39.4342 13.0311C40.3397 13.9073 41.0207 14.9669 41.4769 16.2099C41.9332 17.4529 42.1613 18.8419 42.1613 20.377C42.1613 22.0207 41.8882 23.4947 41.3421 24.7988C40.796 26.1029 40.0356 27.2067 39.0609 28.1101C38.0862 29.0134 36.9282 29.7029 35.5872 30.1783C34.2461 30.6538 32.7874 30.8915 31.2113 30.8915ZM31.315 30.0968C31.8542 30.0968 32.3174 29.944 32.7045 29.6383C33.0916 29.3327 33.4131 28.8266 33.6688 28.1202C33.9246 27.4138 34.1147 26.4799 34.2391 25.3184C34.3636 24.1569 34.4258 22.7271 34.4258 21.0291C34.4258 19.1951 34.367 17.6431 34.2495 16.3729C34.132 15.1028 33.9453 14.0737 33.6896 13.2858C33.4338 12.4979 33.1054 11.9307 32.7045 11.5843C32.3035 11.2379 31.8266 11.0647 31.2735 11.0647C30.7343 11.0647 30.2712 11.2175 29.884 11.5232C29.4969 11.8289 29.1755 12.3349 28.9197 13.0413C28.6639 13.7477 28.4738 14.6782 28.3494 15.8329C28.225 16.9876 28.1627 18.4208 28.1627 20.1325C28.1627 21.9664 28.2215 23.5184 28.339 24.7886C28.4565 26.0588 28.6432 27.0878 28.899 27.8757C29.1547 28.6636 29.4831 29.2308 29.884 29.5772C30.285 29.9236 30.762 30.0968 31.315 30.0968Z" fill="#283455"/>
								<path d="M75.2395 27.0403C75.2395 27.5293 75.2706 27.9369 75.3328 28.2629C75.3951 28.5889 75.4987 28.8572 75.6439 29.0678C75.7891 29.2783 75.9826 29.438 76.2246 29.5466C76.4665 29.6553 76.7673 29.7436 77.1267 29.8115V30.321H66.5708V29.8115C66.8611 29.7436 67.1065 29.6553 67.307 29.5466C67.5075 29.438 67.6699 29.2783 67.7944 29.0678C67.9188 28.8572 68.0087 28.5889 68.064 28.2629C68.1193 27.9369 68.1469 27.5293 68.1469 27.0403V17.1167C68.1469 16.2608 67.9983 15.6563 67.701 15.3031C67.4038 14.9499 66.9095 14.7733 66.2182 14.7733C65.7481 14.7733 65.2781 14.899 64.808 15.1503C64.3379 15.4016 63.9508 15.7039 63.6466 16.0571V16.2812V27.0403C63.6466 27.5293 63.6743 27.9369 63.7296 28.2629C63.7849 28.5889 63.8748 28.8572 63.9992 29.0678C64.1236 29.2783 64.2895 29.438 64.4969 29.5466C64.7043 29.6553 64.9601 29.7436 65.2642 29.8115V30.321H54.9779V29.8115C55.2683 29.7436 55.5137 29.6553 55.7141 29.5466C55.9146 29.438 56.0771 29.2783 56.2015 29.0678C56.3259 28.8572 56.4123 28.5889 56.4607 28.2629C56.5091 27.9369 56.5333 27.5293 56.5333 27.0403V17.1167C56.5333 16.2608 56.3881 15.6563 56.0978 15.3031C55.8075 14.9499 55.3166 14.7733 54.6254 14.7733C54.1415 14.7733 53.6679 14.8888 53.2048 15.1197C52.7416 15.3507 52.3579 15.6427 52.0538 15.9959V27.0403C52.0538 27.5293 52.078 27.9369 52.1264 28.2629C52.1747 28.5889 52.2612 28.8572 52.3856 29.0678C52.51 29.2783 52.6725 29.438 52.8729 29.5466C53.0734 29.6553 53.3188 29.7436 53.6092 29.8115V30.321H43.0532V29.8115C43.4127 29.7436 43.7134 29.6553 43.9554 29.5466C44.1973 29.438 44.3909 29.2783 44.536 29.0678C44.6812 28.8572 44.7849 28.5889 44.8471 28.2629C44.9093 27.9369 44.9404 27.5293 44.9404 27.0403V17.4223C44.9404 16.6888 44.9093 16.0876 44.8471 15.619C44.7849 15.1503 44.6777 14.7665 44.5257 14.4677C44.3736 14.1688 44.18 13.9345 43.945 13.7647C43.7099 13.5949 43.4127 13.4488 43.0532 13.3266V12.8171L52.0123 10.27V15.0179C52.192 14.4473 52.4443 13.8767 52.7692 13.3062C53.0942 12.7356 53.5089 12.2262 54.0136 11.7779C54.5182 11.3296 55.1162 10.9662 55.8075 10.6877C56.4987 10.4093 57.3006 10.27 58.2131 10.27C58.9459 10.27 59.6199 10.3753 60.2351 10.5859C60.8504 10.7964 61.3896 11.1055 61.8528 11.513C62.3159 11.9206 62.6961 12.4266 62.9934 13.0311C63.2906 13.6356 63.4876 14.3386 63.5844 15.1401C63.7503 14.556 63.9957 13.9752 64.3206 13.3979C64.6455 12.8205 65.0603 12.3009 65.565 11.839C66.0696 11.3772 66.6745 11.0002 67.3796 10.7081C68.0847 10.4161 68.9004 10.27 69.8267 10.27C70.6425 10.27 71.3821 10.3991 72.0458 10.6572C72.7094 10.9153 73.2763 11.2957 73.7463 11.7983C74.2164 12.3009 74.5828 12.9292 74.8455 13.6832C75.1082 14.4371 75.2395 15.3031 75.2395 16.2812V27.0403Z" fill="#283455"/>
								<path d="M77.1478 29.8115C77.5073 29.7436 77.808 29.6553 78.0499 29.5466C78.2919 29.4379 78.4854 29.2783 78.6306 29.0678C78.7758 28.8572 78.8795 28.5889 78.9417 28.2629C79.0039 27.9368 79.035 27.5293 79.035 27.0402V11.839H76.8989V10.8406H79.035V8.88436C79.035 7.47156 79.232 6.21158 79.626 5.10443C80.0201 3.99728 80.6008 3.06673 81.3681 2.31279C82.1354 1.55884 83.0859 0.984887 84.2197 0.590932C85.3534 0.196977 86.653 0 88.1185 0C89.2107 0 90.2097 0.0747156 91.1152 0.224147C92.0208 0.373578 92.7501 0.550178 93.3032 0.753948L91.4782 7.27458H90.9597C90.697 6.06555 90.4447 5.0467 90.2027 4.21803C89.9608 3.38937 89.7154 2.72033 89.4665 2.2109C89.2177 1.70148 88.9619 1.33469 88.6992 1.11055C88.4365 0.886398 88.1531 0.774325 87.8489 0.774325C87.3097 0.774325 86.8846 1.00526 86.5735 1.46714C86.2624 1.92902 86.1069 2.61504 86.1069 3.52522V10.8406H91.6026V11.839H86.1276V27.0199C86.1276 27.5089 86.176 27.9198 86.2728 28.2527C86.3696 28.5855 86.5286 28.8538 86.7498 29.0576C86.971 29.2613 87.2613 29.421 87.6208 29.5364C87.9803 29.6519 88.4296 29.7436 88.9688 29.8115V30.3209H77.1478V29.8115Z" fill="#283455"/>
								<path d="M107.281 10.8406H114V11.3296C113.544 11.6149 113.136 11.9138 112.776 12.2262C112.417 12.5387 112.082 12.9122 111.771 13.3469C111.459 13.7817 111.159 14.2945 110.868 14.8854C110.578 15.4763 110.267 16.1793 109.935 16.9944L102.241 35.8024C102.02 36.3593 101.757 36.8925 101.453 37.402C101.149 37.9114 100.783 38.3597 100.354 38.7468C99.9254 39.134 99.4207 39.4397 98.84 39.6638C98.2594 39.8879 97.5819 40 96.8077 40C95.4251 40 94.3605 39.657 93.6139 38.971C92.8673 38.285 92.494 37.3374 92.494 36.1284C92.494 35.585 92.5804 35.0994 92.7533 34.6714C92.9261 34.2435 93.168 33.8801 93.4791 33.5813C93.7902 33.2824 94.16 33.0549 94.5886 32.8986C95.0172 32.7424 95.4873 32.6643 95.9989 32.6643C96.5934 32.6643 97.0911 32.7696 97.492 32.9802C97.893 33.1907 98.2248 33.459 98.4875 33.785C98.7502 34.1111 98.9645 34.4575 99.1304 34.8243C99.2963 35.1911 99.4449 35.5375 99.5763 35.8635C99.7076 36.1895 99.8355 36.4578 99.9599 36.6684C100.084 36.879 100.243 36.9842 100.437 36.9842C100.672 36.9842 100.886 36.8348 101.08 36.5359C101.273 36.2371 101.453 35.8703 101.619 35.4356L102.843 32.379L95.1071 15.2216C94.8168 14.5831 94.5679 14.0567 94.3605 13.6424C94.1531 13.2281 93.9526 12.8783 93.7591 12.593C93.5655 12.3077 93.3581 12.07 93.1369 11.8798C92.9157 11.6896 92.6461 11.5062 92.3281 11.3296V10.8406H104.439V11.3296C103.969 11.4926 103.586 11.6387 103.288 11.7677C102.991 11.8968 102.756 12.0258 102.583 12.1549C102.411 12.2839 102.293 12.4198 102.231 12.5624C102.169 12.7051 102.137 12.8715 102.137 13.0617C102.137 13.2383 102.169 13.442 102.231 13.673C102.293 13.9039 102.379 14.1484 102.49 14.4065L106.099 23.6984L108.795 16.9944C109.071 16.3152 109.285 15.6903 109.437 15.1197C109.59 14.5492 109.666 14.0398 109.666 13.5915C109.666 13.3334 109.628 13.1024 109.552 12.8986C109.475 12.6949 109.344 12.5047 109.157 12.3281C108.971 12.1515 108.725 11.9851 108.421 11.8289C108.117 11.6726 107.737 11.5062 107.281 11.3296V10.8406Z" fill="#283455"/>
							</svg>
						</div>
						<?php echo ! empty( $page['content'] ) ? str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $page['content'] ) ) : ''; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
