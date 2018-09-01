import React, { Fragment } from "react";
import Image from "../../components/Image";
import insurancePic from "../../assets/images/ogden-insurance-nj.jpg";

const Welcome = () => (
  <Fragment>
    <section className="container-full">
      <Image
        className="img-responsive"
        src={insurancePic}
        alt="Ogden Insurance Services NJ"
      />
    </section>
  </Fragment>
);

export default Welcome;
