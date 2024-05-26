import styled from "styled-components";

export default styled.header`
  height: 64px;
  line-height: 64px;
  margin-bottom: 2rem;
  background: black;
  color: ${({ theme }) => theme.grey};
  text-align: center;
`;
