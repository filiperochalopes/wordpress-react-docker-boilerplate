import InputContainer from "./styles";

import PropTypes from "prop-types";
import React from "react";

const Input = ({ type, name, placeholder, formik }) => (
  <InputContainer>
    <input
      type={type}
      name={name}
      id={name}
      placeholder={placeholder}
      onChange={formik.handleChange}
    />
    {formik.errors[name] && <span>{formik.errors[name]}</span>}
  </InputContainer>
);

Input.propTypes = {
  name: PropTypes.string.isRequired,
  type: PropTypes.string,
  placeholder: PropTypes.string,
  formik: PropTypes.object,
};

Input.defaultProps = {
  type: "text",
  placeholder: "Digite seu texto aqui",
};

export default Input;
