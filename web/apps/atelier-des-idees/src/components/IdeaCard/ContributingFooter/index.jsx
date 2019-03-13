import React from 'react';
import PropTypes from 'prop-types';
import classnames from 'classnames';
import { Link } from 'react-router-dom';
import hourglassIcnGreen from './../../../img/icn_hourglass_green.svg';
import greenCheckIcn from '../../../img/icn_checklist.svg';

class ContributingFooter extends React.PureComponent {
    getRemainingDays() {
        const suffix = 1 < this.props.remainingDays ? 's' : '';
        return `${this.props.remainingDays} jour${suffix} restant${suffix}`;
    }

    getRemaininghours() {
        const suffix = 1 < this.props.remainingHours ? 's' : '';
        return `${this.props.remainingHours} heure${suffix} restante${suffix}`;
    }

    render() {
        return (
            <div
                className={classnames('contributing-footer', {
                    'contributing-footer--condensed': this.props.condensed,
                })}
            >
                <div className="contributing-footer__remaining-days">
                    <img className="contributing-footer__remaining-days__icon" src={hourglassIcnGreen} alt="Jours restants" />
                    <span className="contributing-footer__remaining-days__text">
                        <span className="contributing-footer__remaining-days__text--pending">En cours</span> -{' '}
                        {this.props.remainingDays ? this.getRemainingDays() : this.getRemaininghours()}
                    </span>
                </div>
                {!this.props.condensed && (
                    <div className="contributing-footer__container">
                        <Link
                            className={classnames(
                                'contributing-footer__container__link',
                                'button button--primary button--lowercase',
                                {
                                    'contributing-footer__container__link--active': this.props.hasUserContributed,
                                }
                            )}
                            to={this.props.link}
                        >
                            {this.props.hasUserContributed ? (
                                <React.Fragment>
                                    <img src={greenCheckIcn} className="contributing-footer__container__link__icon" alt="Contribuer" />
                  J'ai contribué
                                </React.Fragment>
                            ) : (
                                '+ Je contribue'
                            )}
                        </Link>
                    </div>
                )}
            </div>
        );
    }
}

ContributingFooter.defaultProps = {
    condensed: false,
    hasUserContributed: false,
};

ContributingFooter.propTypes = {
    condensed: PropTypes.bool,
    hasUserContributed: PropTypes.bool,
    link: PropTypes.string.isRequired,
    remainingDays: PropTypes.number.isRequired,
    remainingHours: PropTypes.number.isRequired,
};

export default ContributingFooter;
