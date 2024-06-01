import BannerCard from '@components/common/banner-card';
import Container from '@components/ui/container';
import CategoryBlock from '@containers/category-block';
import { getLayout } from '@components/layout/layout-two';
import NewArrivalsProductFeed from '@components/product/feeds/new-arrivals-product-feed';
import ProductsFlashSaleBlock from '@containers/product-flash-sale-block';
import ProductsFeatured from '@containers/products-featured';
import Subscription from '@components/common/subscription';
import { ROUTES } from '@lib/routes';
import HeroSlider from '@containers/hero-slider';
import BrandGridBlock from '@containers/brand-grid-block';
import {
  fashionHomeHeroGridSlider as heroBanner,
  homeEightCoupons,
  fashionSaleBannerWithProducts,
  elegantHomeBanner,
  fashionSaleBannerDataGallery,
} from '@data/static/banners';
import TestimonialCarousel from '@containers/testimonial-carousel';
import CollectionBlock from '@containers/collection-block';
import { modernDemoCollectionData } from '@data/static/collection';
import SaleBannerWithProducts from '@containers/sale-banner-with-products';
import BannerBlock from '@containers/banner-block';
import Instagram from '@components/common/instagram';
import BannerCarouselBlock from '@containers/banner-carousel-block';

export { getStaticProps } from '@framework/homepage/fashion';

export default function Home() {
  return (
    <>
      <Container>
        <HeroSlider
          data={heroBanner}
          paginationPosition="none"
          variant="fashion"
          className="hero-grid-carousel"
        />

        <CategoryBlock
          sectionHeading="text-browse-categories"
          variant="elegant"
          effectPosition="fullBody"
          type="vector"
        />

        <ProductsFeatured
          sectionHeading="text-featured-products"
          variant="fashion"
          limit={6}
        />

        <BannerCard
          data={elegantHomeBanner}
          href={`${ROUTES.COLLECTIONS}/${elegantHomeBanner.slug}`}
          className="mb-12 md:mb-14 xl:mb-16 pb-0.5 md:pb-0 lg:pb-1 xl:pb-0 md:-mt-2.5"
          classNameInner="aspect-[2/1] md:aspect-[2.9/1]"
        />

        <SaleBannerWithProducts
          sectionHeading="text-on-selling-products"
          categorySlug="/search"
          variant="fashion"
          productVariant="gridSlim"
          limit={8}
          bannerData={fashionSaleBannerWithProducts}
        />

        <BrandGridBlock
          sectionHeading="text-top-brands"
          limit={12}
          variant="6column"
        />

        <ProductsFlashSaleBlock date={'2023-03-01T01:02:03'} variant="slider" />

        <BannerCarouselBlock
          banners={fashionSaleBannerDataGallery}
          showNavigation={false}
        />

        <NewArrivalsProductFeed />

        <BannerCard
          data={homeEightCoupons}
          href={`${ROUTES.COLLECTIONS}/${homeEightCoupons.slug}`}
          className="mb-12 lg:mb-14 xl:mb-16 pb-0.5 lg:pb-1 xl:pb-0"
          classNameInner="aspect-[3.75/1]"
        />

        <CollectionBlock variant="modern" data={modernDemoCollectionData} />

        <TestimonialCarousel sectionHeading="text-testimonial" />

        <Instagram className="mb-12 md:mb-14 xl:mb-16" />

        <Subscription
          className="relative px-5 overflow-hidden sm:px-8 md:px-16 2xl:px-24 sm:items-center lg:items-start"
          variant="modern"
        />
      </Container>
    </>
  );
}

Home.getLayout = getLayout;
