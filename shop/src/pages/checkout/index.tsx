import { useTranslation } from 'next-i18next';
import { billingAddressAtom, shippingAddressAtom } from '@store/checkout';
import dynamic from 'next/dynamic';
import { useUser } from '@framework/auth';
import { AddressType } from '@framework/utils/constants';
import { getLayout } from '@components/layout/layout';
import { Address } from '@type/index';
import Divider from '@components/ui/divider';
import Container from '@components/ui/container';
import Subscription from '@components/common/subscription';

export { getStaticProps } from '@framework/common.ssr';

const ScheduleGrid = dynamic(
  () => import('@components/checkout/schedule/schedule-grid')
);
const AddressGrid = dynamic(() => import('@components/checkout/address-grid'));
const ContactGrid = dynamic(
  () => import('@components/checkout/contact/contact-grid')
);
const RightSideView = dynamic(
  () => import('@components/checkout/right-side-view')
);
const OrderNote = dynamic(() => import('@components/checkout/order-note'));

export default function CheckoutPage() {
  const { me, loading } = useUser();
  const { t } = useTranslation();

  return (
    <>
      {!loading ? (
        <>
          <Divider className="mb-0" />
          <Container className="bg-gray-100">
            <div className="py-8 lg:py-10 lg:px-8 xl:py-14 xl:px-16 2xl:px-20">
              <div className="m-auto flex w-full max-w-5xl flex-col items-center rtl:space-x-reverse lg:flex-row lg:items-start lg:space-x-8">
                <div className="w-full space-y-6 lg:max-w-[600px]">
                  <ContactGrid
                    className="p-5 bg-white border border-gray-100 rounded-md shadow-checkoutCard md:p-7"
                    //@ts-ignore
                    userId={me?.id!}
                    profileId={me?.profile?.id!}
                    contact={me?.profile?.contact!}
                    label={t('text-contact-number')}
                    count={1}
                  />

                  <AddressGrid
                    userId={me?.id!}
                    className="p-5 bg-white border border-gray-100 rounded-md shadow-checkoutCard md:p-7"
                    label={t('text-billing-address')}
                    count={2}
                    //@ts-ignore
                    addresses={me?.address?.filter(
                      (address: Address) =>
                        address?.type === AddressType?.Billing
                    )}
                    //@ts-ignore
                    atom={billingAddressAtom}
                    type={AddressType?.Billing}
                  />
                  <AddressGrid
                    userId={me?.id!}
                    className="p-5 bg-white border border-gray-100 rounded-md shadow-checkoutCard md:p-7"
                    label={t('text-shipping-address')}
                    count={3}
                    //@ts-ignore
                    addresses={me?.address?.filter(
                      (address: Address) =>
                        address?.type === AddressType?.Shipping
                    )}
                    //@ts-ignore
                    atom={shippingAddressAtom}
                    type={AddressType?.Shipping}
                  />
                  <ScheduleGrid
                    className="p-5 md:p-8 bg-white shadow-checkoutCard rounded-md"
                    label={t('text-delivery-schedule')}
                    count={4}
                  />
                  <OrderNote
                    count={5}
                    label={t('Order Note')}
                    className="p-5 bg-white border border-gray-100 rounded-md shadow-checkoutCard md:p-7"
                  />
                </div>
                <div className="mt-8 mb-10 w-full sm:mb-12 lg:my-0 lg:w-96">
                  <RightSideView />
                </div>
              </div>
            </div>
            {/* <Subscription /> */}
          </Container>
        </>
      ) : (
        ''
      )}
    </>
  );
}

CheckoutPage.authenticate = true;
CheckoutPage.getLayout = getLayout;
